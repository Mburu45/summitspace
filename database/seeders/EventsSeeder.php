<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'FIFA Tournament 2025',
                'description' => 'Annual technology conference featuring the latest innovations',
                'location' => 'Nairobi, Kenya, Gamers Hub',
                'event_date' => '2025-12-12',
                'capacity' => 500,
                'price' => 15000.00,
                'category' => 'Technology',
                'created_by' => 1, // Assuming admin user exists
            ],
            [
                'title' => 'Jazz Night Live',
                'description' => 'An evening of smooth jazz with renowned musicians',
                'location' => 'KICC, Nairobi, Kenya',
                'event_date' => '2025-12-12',
                'capacity' => 200,
                'price' => 10000.00,
                'category' => 'Music',
                'created_by' => 1,
            ],
            [
                'title' => 'Hackathon 2025',
                'description' => '48-hour coding competition with amazing prizes',
                'location' => 'Kenyatta University, Nairobi, Kenya',
                'event_date' => '2025-12-12',
                'capacity' => 300,
                'price' => 20000.00,
                'category' => 'Technology',
                'created_by' => 1,
            ],
            [
                'title' => 'Art Gallery Opening',
                'description' => 'Contemporary art exhibition featuring local artists',
                'location' => 'Nairobi National Museum, Nairobi, Kenya',
                'event_date' => '2025-12-12',
                'capacity' => 150,
                'price' => 15000.00,
                'category' => 'Arts',
                'created_by' => 1,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
