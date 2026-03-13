<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PickupPoint;
use Illuminate\Support\Facades\DB;

class PickupPointSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pickup_points')->delete();

        $pickupPoints = [
            // Nairobi pickup points
            [
                'name' => 'Kenya Bus Station',
                'address' => 'Moi Avenue, Nairobi CBD',
                'city' => 'Nairobi',
                'latitude' => -1.2833,
                'longitude' => 36.8167,
                'description' => 'Central bus station in Nairobi CBD',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gigiri Bus Stop',
                'address' => 'Gigiri, UN Avenue',
                'city' => 'Nairobi',
                'latitude' => -1.2655,
                'longitude' => 36.8120,
                'description' => 'Bus stop near UN headquarters',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Westlands Mall',
                'address' => 'Westlands, Mombasa Road',
                'city' => 'Nairobi',
                'latitude' => -1.2621,
                'longitude' => 36.7965,
                'description' => 'Shopping mall pickup point',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thika Road Mall',
                'address' => 'Thika Road, Kasarani',
                'city' => 'Nairobi',
                'latitude' => -1.2192,
                'longitude' => 36.9287,
                'description' => 'Mall pickup point along Thika Road',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Yaya Centre',
                'address' => 'Argwings Kodhek Road, Kilimani',
                'city' => 'Nairobi',
                'latitude' => -1.2956,
                'longitude' => 36.7870,
                'description' => 'Shopping centre pickup point',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Junction Mall',
                'address' => 'Ngong Road, Nairobi',
                'city' => 'Nairobi',
                'latitude' => -1.3015,
                'longitude' => 36.7858,
                'description' => 'Shopping mall pickup point',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Prestige Plaza',
                'address' => 'Langata Road, Nairobi',
                'city' => 'Nairobi',
                'latitude' => -1.3266,
                'longitude' => 36.8175,
                'description' => 'Shopping plaza pickup point',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Garden City Mall',
                'address' => 'Thika Road, Nairobi',
                'city' => 'Nairobi',
                'latitude' => -1.2446,
                'longitude' => 36.9256,
                'description' => 'Shopping mall pickup point',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Mombasa pickup points
            [
                'name' => 'Mombasa Bus Station',
                'address' => 'Digo Road, Mombasa CBD',
                'city' => 'Mombasa',
                'latitude' => -4.0435,
                'longitude' => 39.6682,
                'description' => 'Main bus station in Mombasa',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nyali Centre',
                'address' => 'Nyali Road, Mombasa',
                'city' => 'Mombasa',
                'latitude' => -4.0623,
                'longitude' => 39.7085,
                'description' => 'Shopping centre pickup point',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'City Mall Nyali',
                'address' => 'Nyali, Mombasa',
                'city' => 'Mombasa',
                'latitude' => -4.0645,
                'longitude' => 39.7098,
                'description' => 'Shopping mall pickup point',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kisumu pickup points
            [
                'name' => 'Kisumu Bus Station',
                'address' => 'Oginga Odinga Street, Kisumu CBD',
                'city' => 'Kisumu',
                'latitude' => -0.0917,
                'longitude' => 34.7680,
                'description' => 'Main bus station in Kisumu',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'United Mall',
                'address' => 'Oginga Odinga Street, Kisumu',
                'city' => 'Kisumu',
                'latitude' => -0.0945,
                'longitude' => 34.7656,
                'description' => 'Shopping mall pickup point',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Nakuru pickup points
            [
                'name' => 'Nakuru Bus Station',
                'address' => 'Kenyatta Avenue, Nakuru CBD',
                'city' => 'Nakuru',
                'latitude' => -0.3031,
                'longitude' => 36.0695,
                'description' => 'Main bus station in Nakuru',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Westside Mall',
                'address' => 'Nakuru-Nairobi Highway',
                'city' => 'Nakuru',
                'latitude' => -0.2986,
                'longitude' => 36.0789,
                'description' => 'Shopping mall pickup point',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Eldoret pickup points
            [
                'name' => 'Eldoret Bus Station',
                'address' => 'Uasin Gishu Road, Eldoret CBD',
                'city' => 'Eldoret',
                'latitude' => 0.5143,
                'longitude' => 35.2699,
                'description' => 'Main bus station in Eldoret',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Zucchini Mall',
                'address' => 'Eldoret-Nairobi Highway',
                'city' => 'Eldoret',
                'latitude' => 0.5200,
                'longitude' => 35.2789,
                'description' => 'Shopping mall pickup point',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pickup_points')->insert($pickupPoints);
    }
}
