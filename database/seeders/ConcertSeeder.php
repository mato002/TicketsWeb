<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Concert;
use Carbon\Carbon;

class ConcertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $concerts = [
            [
                'title' => 'Rock Revolution 2024',
                'description' => 'The biggest rock concert of the year featuring top international artists.',
                'event_type' => 'music',
                'organizer' => 'The Rock Legends',
                'venue' => 'Madison Square Garden',
                'venue_address' => '4 Pennsylvania Plaza, New York, NY 10001',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'latitude' => 40.7505,
                'longitude' => -73.9934,
                'event_date' => Carbon::now()->addDays(30),
                'event_time' => '20:00:00',
                'duration_minutes' => 180,
                'base_price' => 15000.00,
                'total_tickets' => 20000,
                'available_tickets' => 18500,
                'image_url' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=500',
                'status' => 'published',
                'featured' => true,
                'ticket_categories' => [
                    ['name' => 'VIP', 'price' => 30000.00, 'quantity' => 500],
                    ['name' => 'Premium', 'price' => 20000.00, 'quantity' => 2000],
                    ['name' => 'Regular', 'price' => 15000.00, 'quantity' => 16000]
                ]
            ],
            [
                'title' => 'Jazz Night Under the Stars',
                'description' => 'An intimate jazz performance in the beautiful outdoor amphitheater.',
                'event_type' => 'music',
                'organizer' => 'Smooth Jazz Collective',
                'venue' => 'Central Park Bandshell',
                'venue_address' => 'Central Park, New York, NY 10024',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'latitude' => 40.7829,
                'longitude' => -73.9654,
                'event_date' => Carbon::now()->addDays(45),
                'event_time' => '19:30:00',
                'duration_minutes' => 120,
                'base_price' => 8500.00,
                'total_tickets' => 5000,
                'available_tickets' => 4200,
                'image_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=500',
                'status' => 'published',
                'featured' => false,
                'ticket_categories' => [
                    ['name' => 'VIP Seating', 'price' => 15000.00, 'quantity' => 200],
                    ['name' => 'Premium', 'price' => 12000.00, 'quantity' => 800],
                    ['name' => 'General', 'price' => 8500.00, 'quantity' => 4000]
                ]
            ],
            [
                'title' => 'Pop Festival 2024',
                'description' => 'A day-long festival featuring the hottest pop artists and emerging talents.',
                'event_type' => 'music',
                'organizer' => 'Various Artists',
                'venue' => 'Brooklyn Bridge Park',
                'venue_address' => '334 Furman St, Brooklyn, NY 11201',
                'city' => 'Brooklyn',
                'state' => 'NY',
                'country' => 'USA',
                'latitude' => 40.6962,
                'longitude' => -73.9969,
                'event_date' => Carbon::now()->addDays(60),
                'event_time' => '14:00:00',
                'duration_minutes' => 360,
                'base_price' => 12000.00,
                'total_tickets' => 15000,
                'available_tickets' => 12000,
                'image_url' => 'https://images.unsplash.com/photo-1571266028243-e68f8578b6b8?w=500',
                'status' => 'published',
                'featured' => true,
                'ticket_categories' => [
                    ['name' => 'VIP Pass', 'price' => 25000.00, 'quantity' => 1000],
                    ['name' => 'Early Bird', 'price' => 9000.00, 'quantity' => 3000],
                    ['name' => 'General', 'price' => 12000.00, 'quantity' => 11000]
                ]
            ],
            [
                'title' => 'Classical Symphony Evening',
                'description' => 'Experience the beauty of classical music with world-renowned symphony orchestra.',
                'event_type' => 'music',
                'organizer' => 'New York Philharmonic',
                'venue' => 'Carnegie Hall',
                'venue_address' => '881 7th Ave, New York, NY 10019',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'latitude' => 40.7648,
                'longitude' => -73.9808,
                'event_date' => Carbon::now()->addDays(15),
                'event_time' => '20:00:00',
                'duration_minutes' => 120,
                'base_price' => 20000.00,
                'total_tickets' => 2804,
                'available_tickets' => 1500,
                'image_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=500',
                'status' => 'published',
                'featured' => false,
                'ticket_categories' => [
                    ['name' => 'Orchestra', 'price' => 35000.00, 'quantity' => 500],
                    ['name' => 'Mezzanine', 'price' => 25000.00, 'quantity' => 800],
                    ['name' => 'Balcony', 'price' => 20000.00, 'quantity' => 1504]
                ]
            ],
            [
                'title' => 'Electronic Dance Night',
                'description' => 'Dance the night away with the best DJs and electronic music artists.',
                'event_type' => 'music',
                'organizer' => 'DJ Collective',
                'venue' => 'Brooklyn Mirage',
                'venue_address' => '140 Stewart Ave, Brooklyn, NY 11237',
                'city' => 'Brooklyn',
                'state' => 'NY',
                'country' => 'USA',
                'latitude' => 40.6892,
                'longitude' => -73.9442,
                'event_date' => Carbon::now()->addDays(20),
                'event_time' => '22:00:00',
                'duration_minutes' => 240,
                'base_price' => 7500.00,
                'total_tickets' => 6000,
                'available_tickets' => 5800,
                'image_url' => 'https://images.unsplash.com/photo-1571266028243-e68f8578b6b8?w=500',
                'status' => 'draft',
                'featured' => false,
                'ticket_categories' => [
                    ['name' => 'VIP Booth', 'price' => 15000.00, 'quantity' => 100],
                    ['name' => 'Premium', 'price' => 10000.00, 'quantity' => 500],
                    ['name' => 'General', 'price' => 7500.00, 'quantity' => 5400]
                ]
            ]
        ];

        foreach ($concerts as $concertData) {
            Concert::create($concertData);
        }
    }
}
