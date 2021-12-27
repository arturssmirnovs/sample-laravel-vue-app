<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gender = [
            ['name' => 'Male'],
            ['name' => 'Female'],
            ['name' => 'Other'],
        ];

        foreach ($gender as $item) {
            Gender::create($item);
        }
    }
}
