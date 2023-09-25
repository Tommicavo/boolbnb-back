<?php

namespace Database\Seeders;

use App\Models\Estate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estates = config('estates');

        foreach ($estates as $estate) {
            $new_estate = new Estate();
            $new_estate->fill($estate);
            $new_estate->save();
        }
    }
}
