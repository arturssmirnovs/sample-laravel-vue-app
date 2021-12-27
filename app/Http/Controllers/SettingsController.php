<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Gender;
use App\Models\Language;
use App\Models\Timezone;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsController extends Controller
{
    /**
     * Public settings endpoint
     *
     * @return JsonResource
     */
    public function public()
    {
        return new JsonResource([
            'locales' => ['en', 'lv', 'ru'],
            'default_locale' => 'en',
            'providers' => [
                'github',
                'linkedin',
                'facebook',
                'google'
            ],
            'countries' => Country::query()->orderBy('name')->get(),
            'languages' => Language::query()->orderBy('name')->get(),
            'timezones' => Timezone::query()->orderBy('id')->get(),
            'genders' => Gender::query()->orderBy('name')->get()
        ]);
    }
}
