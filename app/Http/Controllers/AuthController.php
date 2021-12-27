<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CodeRequest;
use App\Http\Requests\EditNotificationsRequest;
use App\Http\Requests\EditPreferencesRequest;
use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\Set2faRequest;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Models\PersonalAccessTokenAttributes;
use App\Models\Team;
use App\Models\User;
use App\Models\UserCode;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Login endpoint
     *
     * @param LoginRequest $request
     * @return TokenResource
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if ($user && $user->need2FA()) {
            $user->send2FACode();

            session([
                '2fa' => 'true',
                '2fa_user_id' => $user->id
            ]);

            throw ValidationException::withMessages([
                'code' => ['2FA Code is required']
            ]);
        }

        if ($user && Hash::check($request->password, $user->password))
        {
            $token = $user->createToken('Personal Access Token');

            PersonalAccessTokenAttributes::create([
                'token_id' => $token->accessToken->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return new TokenResource($token);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }

    /**
     * Login endpoint
     *
     * @param CodeRequest $request
     * @return TokenResource
     * @throws ValidationException
     */
    public function code(CodeRequest $request)
    {
        $providedCode = $request->validated()['code'];

        if ($request->session()->get('2fa') && $request->session()->get('2fa_user_id')) {
            $userCode = UserCode::where('user_id', $request->session()->get('2fa_user_id'))->first();
            if ($userCode) {
                if ($providedCode == $userCode->code) {

                    $token = $userCode->user->createToken('Personal Access Token');

                    PersonalAccessTokenAttributes::create([
                        'token_id' => $token->accessToken->id,
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent()
                    ]);

                    $userCode->delete();

                    $request->session()->remove('2fa');

                    $request->session()->remove('2fa_user_id');

                    return new TokenResource($token);
                } else {
                    throw ValidationException::withMessages([
                        'code' => ['Incorrect provided code']
                    ]);
                }
            }
        }

        throw ValidationException::withMessages([
            'code' => ['Something went wrong']
        ]);
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return JsonResource
     */
    public function redirectToProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'github', 'google'])) {
            return new JsonResource([
                'url' => null
            ]);
        }

        return new JsonResource([
            'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl()
        ]);
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return JsonResource
     */
    public function handleProviderCallback($provider)
    {
        if (!in_array($provider, ['facebook', 'github', 'google'])) {
            throw ValidationException::withMessages([
                'provider' => ['Incorrect provider']
            ]);
        }

        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            throw ValidationException::withMessages([
                'code' => ['Invalid credentials provided.']
            ]);
        }

        $fullname = $user->getName();
        $parts = explode(" ", $fullname);

        $name = @$parts[0] ? $parts[0] : '-';
        $surname = @$parts[1] ? $parts[1] : '-';

        $userCreated = User::query()->where('email', $user->getEmail())->first();

        if (!$userCreated) {
            $userCreated = User::create([
                'name' => $name,
                'email' => $user->getEmail(),
                'surname' => $surname,
                'notifications' => ["APP"]
            ]);

            $team = Team::create([
                'name' => 'Initial team',
                'user_id' => $userCreated->id
            ]);

            $team->users()->attach($userCreated, ['type' => 'user', 'role' => 'admin']);

            $userCreated->switchTeam($team);
        }

        if (!$userCreated->hasVerifiedEmail()) {
            $userCreated->markEmailAsVerified();
        }

        $userCreated->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $user->getId(),
            ],
            [
                'avatar' => $user->getAvatar()
            ]
        );

        if ($userCreated && $userCreated->need2FA() && !\auth()->user()) {
            $userCreated->send2FACode();

            session([
                '2fa' => 'true',
                '2fa_user_id' => $userCreated->id
            ]);

            throw ValidationException::withMessages([
                'code' => ['2FA Code is required']
            ]);
        }

        $token = $userCreated->createToken('Personal Access Token');

        PersonalAccessTokenAttributes::create([
            'token_id' => $token->accessToken->id,
            'ip_address' => \request()->ip(),
            'user_agent' => \request()->userAgent()
        ]);

        return new TokenResource($token);
    }

    /**
     * Remove provider from user
     *
     * @param Request $request
     * @param $provider
     * @return JsonResource
     */
    public function removeProvider(Request $request, $provider)
    {
        $user = $request->user();

        $user->providers()->where('provider', $provider)->delete();

        return new UserResource($request->user());
    }

    /**
     * Remove provider from user
     *
     * @param Request $request
     * @param $id
     * @return JsonResource
     */
    public function removeSession(Request $request, $id)
    {
        $user = $request->user();

        $user->tokens()->where('id', $id)->delete();

        return new UserResource($request->user());
    }

    /**
     * Register endpoint
     *
     * @param RegisterRequest $request
     * @return TokenResource
     */
    public function register(RegisterRequest $request)
    {
        $validated = collect($request->validated());

        $validated->put('password', Hash::make($validated['password']));

        $user = User::create(array_merge(
            $validated->toArray(),
            ['notifications' => ["APP"]]
        ));

        $token = $user->createToken('Personal Access Token');

        $team = Team::create([
            'name' => 'Initial team',
            'user_id' => $user->id
        ]);

        $team->users()->attach($user, ['type' => 'user', 'role' => 'admin']);

        $user->switchTeam($team);

        PersonalAccessTokenAttributes::create([
            'token_id' => $token->accessToken->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        event(new Registered($user));

        return new TokenResource($token);
    }

    /**
     * Logout endpoint
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $userId = $request->user()->id;

        $request->user()->currentAccessToken()->delete();

        DB::table('sessions')->where('user_id', $userId)->delete();

        return response()->noContent();
    }

    /**
     * Logged in user profile endpoint
     *
     * @param Request $request
     * @return UserResource
     */
    public function profile(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Logged in user profile endpoint
     *
     * @param Request $request
     * @return UserResource
     */
    public function profileEdit(EditProfileRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($file = $request->file('file')) {
            $file->store('picture', ['disk' => 'public']);
            $request->user()->picture = $file->hashName();
        }

        if ($request->post('delete_file') &&  $request->user()->picture) {
            $request->user()->picture = null;
            Storage::disk('public')->delete('picture/'. $request->user()->picture);
        }

        $request->user()->save();

        return new UserResource($request->user());
    }

    /**
     * Logged in user profile endpoint
     *
     * @param Request $request
     * @return UserResource
     */
    public function profileNotifications(EditNotificationsRequest $request)
    {
        $request->user()->fill($request->validated());

        $request->user()->save();

        return new UserResource($request->user());
    }

    /**
     * Logged in user profile endpoint
     *
     * @param EditPreferencesRequest $request
     * @return UserResource
     */
    public function profilePreferences(EditPreferencesRequest $request)
    {
        $request->user()->fill($request->validated());

        $request->user()->save();

        return new UserResource($request->user());
    }

    /**
     * Logged in user profile endpoint
     *
     * @param Request $request
     * @return UserResource
     */
    public function profileDelete(Request $request)
    {
        return $request->user()->delete();
    }

    /**
     * Send reset email
     *
     * @param ForgotPasswordRequest $request
     * @return JsonResource
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return new JsonResource([
            'success' => $status === Password::RESET_LINK_SENT
        ]);
    }

    /**
     * Reset password
     *
     * @param ResetPasswordRequest $request
     * @return JsonResource
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return new JsonResource([
            'success' => $status === Password::PASSWORD_RESET
        ]);
    }

    /**
     * Verify email request
     *
     * @param Request $request
     * @return JsonResource
     */
    public function verify(Request $request) {
        if (!Request::create(URL::route('verification.verify', [
            'id' => $request->post('id'),
            'hash' => $request->post('hash'),
            'expires' => $request->get('expires'),
            'signature' => $request->get('signature'),
        ]))->hasValidSignature(true)) {
            abort(500);
        }

        $user = User::find($request->get('id'));

        if (!$user) {
            return new JsonResource([
                'success' => false
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return new JsonResource([
                'success' => true
            ]);
        }

        if ($user->markEmailAsVerified()) {
            return new JsonResource([
                'success' => true
            ]);
        }

        return new JsonResource([
            'success' => false
        ]);
    }

    /**
     * Resend email verification email
     *
     * @param Request $request
     * @return JsonResource
     */
    public function resend(Request $request) {
        if ($request->user()->email_verified_at) {
            return new JsonResource([
                'success' => false
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return new JsonResource([
            'success' => true
        ]);
    }

    /**
     * Register endpoint
     *
     * @param ChangePasswordRequest $request
     * @return JsonResource
     */
    public function password(ChangePasswordRequest $request)
    {
        $validated = collect($request->validated());

        return new JsonResource([
            'success' => \auth()->user()->fill(['password' => Hash::make($validated->get('password_new'))])->save()
        ]);
    }

    /**
     * Setup 2FA code
     *
     * @param Set2faRequest $request
     * @return JsonResource
     * @throws ValidationException
     */
    public function set2fa(Set2faRequest $request) {
        if (!$request->post('code')) {
            $request->user()->send2FACode();

            throw ValidationException::withMessages([
                'code' => ["We have sent you 2FA code, please enter it."]
            ]);
        }

        if ($request->post('code') !== $request->user()->code?->code) {
            throw ValidationException::withMessages([
                'code' => ["Verification code don't match"]
            ]);
        }

        $request->user()->enabled_2fa = true;

        $request->user()->phone = $request->post('phone');

        $request->user()->code?->delete();

        return new JsonResource([
            'success' => $request->user()->save()
        ]);
    }

    /**
     * Remove 2FA
     *
     * @param Request $request
     * @return JsonResource
     */
    public function remove2fa(Request $request) {
        $request->user()->enabled_2fa = false;

        return new JsonResource([
            'success' => $request->user()->save()
        ]);
    }
}
