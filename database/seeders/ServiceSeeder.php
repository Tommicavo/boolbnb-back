<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['label' => 'Parking', 'icon' => 'square-parking'],
            ['label' => 'WiFi', 'icon' => 'wifi'],
            ['label' => 'Kitchen', 'icon' => 'kitchen-set'],
            ['label' => 'TV', 'icon' => 'tv'],
            ['label' => 'Pool', 'icon' => 'water-ladder']
        ];

        foreach ($services as $service) {
            $new_service = new  Service();
            $new_service->label = $service['label'];
            $new_service->icon = $service['icon'];
            $new_service->save();
        };
    }
}
