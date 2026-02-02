<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Service;






class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Obtener IDs de ejemplo
        $user = User::first();
        $service = Service::first();

        Reservation::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'date' => '2026-02-10',
            'time' => '10:00:00',
            'status' => 'confirmed',
            'notes' => 'Reserva generada automáticamente',
        ]);
    }
}
