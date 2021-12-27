<?php

namespace App\Http\Resources;

use App\Models\Session;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'phone' => $this->phone,
            'enabled_2fa' => (boolean)$this->enabled_2fa,
            'email_verified_at' => $this->email_verified_at,
            'current_team_id' => $this->current_team_id,
            'current_team' => new TeamResource($this->currentTeam),
            'teams' => new TeamCollection($this->teams),
            'gender_id' => $this->gender_id,
            'timezone_id' => $this->timezone_id,
            'country_id' => $this->country_id,
            'language_id' => $this->language_id,
            'notifications' => $this->notifications,
            'picture' => $this->picture,
            'bio' => $this->bio,
            'providers' => new ProviderCollection($this->providers),
            'sessions' => new SessionCollection(
                $this->tokens()
                ->select(DB::raw("personal_access_tokens.*, personal_access_token_attributes.ip_address, personal_access_token_attributes.user_agent"))
                ->leftJoin('personal_access_token_attributes', 'personal_access_token_attributes.token_id', '=','personal_access_tokens.id')
                ->orderByDesc('id')
                ->get()
            ),
        ];
    }
}
