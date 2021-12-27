<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Jenssegers\Agent\Agent;

class SessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $agent = new Agent();
        $agent->setUserAgent($this->user_agent);

        $isActive = @explode("|", $request->bearerToken())[0];

        return [
            'id' => $this->id,
            'device' => $agent->device(),
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'is_phone' => $agent->isPhone(),
            'is_desktop' => $agent->isDesktop(),
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'updated_at' => $this->updated_at,
            'active' => $isActive == $this->id,
            'ago' => Carbon::parse($this->updated_at)->diffForHumans()
        ];
    }
}
