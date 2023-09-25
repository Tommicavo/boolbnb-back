<?php

namespace Database\Seeders;

use App\Models\Message;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        for ($i = 0; $i < 5; $i++) {
            $message = new Message();

            $message->name = $faker->firstName($gender = 'male');
            $message->email = $faker->email();
            $message->text = $faker->paragraph();

            $message->save();
        }
    }
}
