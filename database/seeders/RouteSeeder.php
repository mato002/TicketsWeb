<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('routes')->delete();

        $routes = [
            [
                'name' => 'Nairobi to Kasarani Stadium',
                'start_location' => 'Nairobi CBD',
                'end_location' => 'Kasarani Stadium',
                'distance_km' => 12.5,
                'base_price' => 500.00,
                'description' => 'Direct route from Nairobi city center to Kasarani Stadium',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nairobi to KICC',
                'start_location' => 'Nairobi CBD',
                'end_location' => 'Kenyatta International Convention Centre',
                'distance_km' => 2.0,
                'base_price' => 200.00,
                'description' => 'Short route within Nairobi to KICC',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nairobi to Ngong Racecourse',
                'start_location' => 'Nairobi CBD',
                'end_location' => 'Ngong Racecourse',
                'distance_km' => 15.0,
                'base_price' => 600.00,
                'description' => 'Route to Ngong Racecourse for outdoor events',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nairobi to Bomas of Kenya',
                'start_location' => 'Nairobi CBD',
                'end_location' => 'Bomas of Kenya',
                'distance_km' => 18.0,
                'base_price' => 700.00,
                'description' => 'Route to Bomas of Kenya cultural events',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nairobi to Carnivore Grounds',
                'start_location' => 'Nairobi CBD',
                'end_location' => 'Carnivore Grounds',
                'distance_km' => 8.5,
                'base_price' => 400.00,
                'description' => 'Popular route to Carnivore for concerts and events',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nairobi to The Hub Karen',
                'start_location' => 'Nairobi CBD',
                'end_location' => 'The Hub Karen',
                'distance_km' => 25.0,
                'base_price' => 1000.00,
                'description' => 'Route to Karen shopping and entertainment complex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nairobi to Two Rivers Mall',
                'start_location' => 'Nairobi CBD',
                'end_location' => 'Two Rivers Mall',
                'distance_km' => 16.0,
                'base_price' => 650.00,
                'description' => 'Route to Two Rivers Mall events and concerts',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nairobi to Garden City Mall',
                'start_location' => 'Nairobi CBD',
                'end_location' => 'Garden City Mall',
                'distance_km' => 14.0,
                'base_price' => 550.00,
                'description' => 'Route to Garden City Mall for events',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nairobi to JKIA',
                'start_location' => 'Nairobi CBD',
                'end_location' => 'Jomo Kenyatta International Airport',
                'distance_km' => 20.0,
                'base_price' => 800.00,
                'description' => 'Airport transfer route for international artists and events',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nairobi to Village Market',
                'start_location' => 'Nairobi CBD',
                'end_location' => 'Village Market',
                'distance_km' => 22.0,
                'base_price' => 900.00,
                'description' => 'Route to Village Market for concerts and events',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mombasa to Mombasa Beach',
                'start_location' => 'Mombasa CBD',
                'end_location' => 'Mombasa Beach Hotel',
                'distance_km' => 8.0,
                'base_price' => 450.00,
                'description' => 'Coastal route for beach events and concerts',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kisumu to Dunga Beach',
                'start_location' => 'Kisumu CBD',
                'end_location' => 'Dunga Beach',
                'distance_km' => 10.0,
                'base_price' => 500.00,
                'description' => 'Route to Dunga Beach for lakeside events',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('routes')->insert($routes);
    }
}
