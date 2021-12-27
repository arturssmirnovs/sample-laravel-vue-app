<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/scheduler', function () {
    //return shell_exec("docker exec -it kali whatweb example.com -v -q");
});

Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::post('/verify', [\App\Http\Controllers\AuthController::class, 'verify']);

Route::post('/forgot', [\App\Http\Controllers\AuthController::class, 'forgotPassword']);

Route::post('/reset', [\App\Http\Controllers\AuthController::class, 'resetPassword']);

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::get('/login/{provider}', [\App\Http\Controllers\AuthController::class, 'redirectToProvider']);

Route::post('/login/{provider}/callback', [\App\Http\Controllers\AuthController::class, 'handleProviderCallback'])->middleware('auth_optional');

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::apiResource('teams', \App\Http\Controllers\TeamController::class);

    Route::apiResource('projects', \App\Http\Controllers\ProjectController::class);

    Route::apiResource('notes', \App\Http\Controllers\NoteController::class);

    Route::apiResource('targets', \App\Http\Controllers\TargetController::class);

    Route::post('/teams/switch/{id}', [\App\Http\Controllers\TeamController::class, 'switchTeam']);

    Route::get('/profile', [\App\Http\Controllers\AuthController::class, 'profile']);

    Route::post('/profile', [\App\Http\Controllers\AuthController::class, 'profileEdit']);

    Route::post('/preferences', [\App\Http\Controllers\AuthController::class, 'profilePreferences']);

    Route::post('/notifications', [\App\Http\Controllers\AuthController::class, 'profileNotifications']);

    Route::delete('/profile', [\App\Http\Controllers\AuthController::class, 'profileDelete']);

    Route::delete('/login/{provider}', [\App\Http\Controllers\AuthController::class, 'removeProvider']);

    Route::delete('/session/{id}', [\App\Http\Controllers\AuthController::class, 'removeSession']);

    Route::post('/2fa', [\App\Http\Controllers\AuthController::class, 'set2fa']);

    Route::delete('/2fa', [\App\Http\Controllers\AuthController::class, 'remove2fa']);

    Route::post('/resend', [\App\Http\Controllers\AuthController::class, 'resend']);

    Route::post('/password', [\App\Http\Controllers\AuthController::class, 'password']);

    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});

Route::get('/settings/public', [\App\Http\Controllers\SettingsController::class, 'public']);

Route::get('/translations/messages', [\App\Http\Controllers\TranslationsController::class, 'messages']);
