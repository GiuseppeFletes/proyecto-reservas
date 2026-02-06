<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Corte de cabello',
            'description' => 'Corte de cabello basico para mujer o hombre',
            'duration' => '30',
            'price' => 120.00,
        ]);
        Service::create([
            'name' => 'Afeitado completo',
            'description' => 'Afeitado a navaja con toalla caliente',
            'duration' => '20',
            'price' => 90.00,
        ]);
        Service::create([
            'name' => 'Tinte de cabello',
            'description' => 'Aplicacion de tinte completo',
            'duration' => '90',
            'price' => 250.00,
        ]);
    }
}
