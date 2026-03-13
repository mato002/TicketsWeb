<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed all data
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            ConcertSeeder::class,
            AccommodationSeeder::class,
            VehicleSeeder::class,
            RouteSeeder::class,
            PickupPointSeeder::class,
            TransportScheduleSeeder::class,
        ]);
    }
}
