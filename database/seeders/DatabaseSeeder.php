<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AddressSeeder::class,
            CategorySeeder::class,
            EstateSeeder::class,
            ImageSeeder::class,
            MessageSeeder::class,
            ServiceSeeder::class,
            SponsorshipSeeder::class,
            VisitSeeder::class,
        ]);
    }
}
