<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Estate;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $estate_ids = Estate::pluck('id')->toArray();
        for ($i = 0; $i < 2; $i++) {
            $address = new Address();

            $address->toponymic = $faker->cityPrefix();
            $address->street_name = $faker->streetName();
            $address->number = $faker->randomDigit();
            $address->zip_code = $faker->postcode();
            $address->city = $faker->city();
            $address->latitude = $faker->latitude();
            $address->longitude = $faker->longitude();
            $address->estate_id = Arr::random($estate_ids);
            $address->save();
        }
    }
}
