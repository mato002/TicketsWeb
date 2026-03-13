<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransportSchedule;
use App\Models\Event;
use App\Models\Vehicle;
use App\Models\Route;
use App\Models\PickupPoint;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransportScheduleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transport_schedules')->delete();

        // Get sample data
        $events = Event::take(5)->get();
        $vehicles = Vehicle::all();
        $routes = Route::all();
        $pickupPoints = PickupPoint::all();

        if ($events->isEmpty() || $vehicles->isEmpty() || $routes->isEmpty()) {
            $this->command->info('Skipping TransportScheduleSeeder - missing required data');
            return;
        }

        $schedules = [];

        foreach ($events as $index => $event) {
            // Create 2-3 transport schedules for each event
            $scheduleCount = rand(2, 3);
            
            for ($i = 0; $i < $scheduleCount; $i++) {
                $vehicle = $vehicles->random();
                $route = $routes->random();
                $pickupPoint = $pickupPoints->where('city', $event->city)->first() ?: $pickupPoints->random();
                
                // Calculate departure time (2-4 hours before event)
                $hoursBefore = rand(2, 4);
                $departureTime = Carbon::parse($event->event_date)->subHours($hoursBefore);
                $travelTime = $route->distance_km / 60; // Assuming 60 km/h average speed
                $arrivalTime = $departureTime->copy()->addMinutes($travelTime * 60);
                
                // Calculate price based on vehicle and route
                $basePrice = max($route->base_price, $route->distance_km * $vehicle->price_per_km);
                $price = round($basePrice * (1 + rand(-10, 20) / 100), 2); // Add some variation

                $schedules[] = [
                    'event_id' => $event->id,
                    'vehicle_id' => $vehicle->id,
                    'route_id' => $route->id,
                    'pickup_point_id' => $pickupPoint->id,
                    'departure_time' => $departureTime,
                    'arrival_time' => $arrivalTime,
                    'price' => $price,
                    'available_seats' => $vehicle->capacity,
                    'booked_seats' => rand(0, (int)($vehicle->capacity * 0.7)), // Some pre-booking
                    'is_active' => true,
                    'notes' => "Transport to {$event->title} from {$pickupPoint->name}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Add some additional schedules for future events
        for ($i = 0; $i < 10; $i++) {
            $event = $events->random();
            $vehicle = $vehicles->random();
            $route = $routes->random();
            $pickupPoint = $pickupPoints->random();
            
            // Random future date within next 30 days
            $eventDate = Carbon::now()->addDays(rand(1, 30))->setHour(18)->setMinute(0)->setSecond(0);
            $hoursBefore = rand(2, 4);
            $departureTime = $eventDate->copy()->subHours($hoursBefore);
            $travelTime = $route->distance_km / 60;
            $arrivalTime = $departureTime->copy()->addMinutes($travelTime * 60);
            
            $basePrice = max($route->base_price, $route->distance_km * $vehicle->price_per_km);
            $price = round($basePrice * (1 + rand(-10, 20) / 100), 2);

            $schedules[] = [
                'event_id' => $event->id,
                'vehicle_id' => $vehicle->id,
                'route_id' => $route->id,
                'pickup_point_id' => $pickupPoint->id,
                'departure_time' => $departureTime,
                'arrival_time' => $arrivalTime,
                'price' => $price,
                'available_seats' => $vehicle->capacity,
                'booked_seats' => rand(0, (int)($vehicle->capacity * 0.5)),
                'is_active' => true,
                'notes' => "Transport service available",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($schedules, 50) as $chunk) {
            DB::table('transport_schedules')->insert($chunk);
        }

        $this->command->info('Transport schedules seeded successfully!');
    }
}
