<?php

namespace App\Http\Controllers;

use \Illuminate\Support\Collection;

class TranslationsController extends Controller
{
    /**
     * Public settings endpoint
     *
     * @return Collection
     */
    public function messages()
    {
        return new Collection([
            'en' => [
                'test' => 'Tests'
            ]
        ]);
    }
}
