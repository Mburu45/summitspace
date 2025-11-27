<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = [
            [
                'id' => 1,
                'title' => 'Fifa tournament',
                'date' => '2024-11-01',
                'location' => 'Nairobi, Kenya, Gamers Hub',
                'category' => 'Technology',
                'description' => 'Annual technology conference featuring the latest innovations',
                'price' => '15,000ksh',
                'image' => '/images/event1.png',
                'attendees' => 500,
                'rating' => 4.8
            ],
            [
                'id' => 2,
                'title' => 'Jazz Night Live',
                'date' => '2024-11-20',
                'location' => 'KICC, Nairobi, Kenya',
                'category' => 'Music',
                'description' => 'An evening of smooth jazz with renowned musicians',
                'price' => '10,000ksh',
                'image' => '/images/event2.png',
                'attendees' => 200,
                'rating' => 4.9
            ],
            [
                'id' => 3,
                'title' => 'Hackathon 2024',
                'date' => '2024-12-05',
                'location' => 'Kenyatta University, Nairobi, Kenya',
                'category' => 'Technology',
                'description' => '48-hour coding competition with amazing prizes',
                'price' => '20,000ksh',
                'image' => '/images/event3.png',
                'attendees' => 300,
                'rating' => 4.7
            ],
            [
                'id' => 4,
                'title' => 'Art Gallery Opening',
                'date' => '2024-09-30',
                'location' => 'Nairobi National Museum, Nairobi, Kenya',
                'category' => 'Arts',
                'description' => 'Contemporary art exhibition featuring local artists',
                'price' => '15,000ksh',
                'image' => '/images/event1.png',
                'attendees' => 150,
                'rating' => 4.5
            ]
        ];

        $searchTerm = $request->query('search', '');
        $filterCategory = $request->query('category', 'all');

        $filteredEvents = collect($events)->filter(function ($event) use ($searchTerm, $filterCategory) {
            $matchesSearch = stripos($event['title'], $searchTerm) !== false ||
                             stripos($event['description'], $searchTerm) !== false;

            $matchesCategory = $filterCategory === 'all' || strtolower($event['category']) === strtolower($filterCategory);

            return $matchesSearch && $matchesCategory;
        })->all();

        $categories = array_unique(array_map(fn($e) => $e['category'], $events));

        return view('events.index', compact('filteredEvents', 'categories', 'searchTerm', 'filterCategory'));
    }

    public function show($id)
    {
        $events = [
            1 => [
                'id' => 1,
                'title' => 'Fifa tournament',
                'date' => '2024-11-01',
                'location' => 'Nairobi, Kenya, Gamers Hub',
                'category' => 'Technology',
                'description' => 'Annual technology conference featuring the latest innovations',
                'price' => '15,000ksh',
                'image' => '/images/event1.png',
                'attendees' => 500,
                'rating' => 4.8
            ],
            2 => [
                'id' => 2,
                'title' => 'Jazz Night Live',
                'date' => '2024-11-20',
                'location' => 'KICC, Nairobi, Kenya',
                'category' => 'Music',
                'description' => 'An evening of smooth jazz with renowned musicians',
                'price' => '10,000ksh',
                'image' => '/images/event2.png',
                'attendees' => 200,
                'rating' => 4.9
            ],
            3 => [
                'id' => 3,
                'title' => 'Hackathon 2024',
                'date' => '2024-12-05',
                'location' => 'Kenyatta University, Nairobi, Kenya',
                'category' => 'Technology',
                'description' => '48-hour coding competition with amazing prizes',
                'price' => '20,000ksh',
                'image' => '/images/event3.png',
                'attendees' => 300,
                'rating' => 4.7
            ],
            4 => [
                'id' => 4,
                'title' => 'Art Gallery Opening',
                'date' => '2024-09-30',
                'location' => 'Nairobi National Museum, Nairobi, Kenya',
                'category' => 'Arts',
                'description' => 'Contemporary art exhibition featuring local artists',
                'price' => '15,000ksh',
                'image' => '/images/event1.png',
                'attendees' => 150,
                'rating' => 4.5
            ]
        ];

        $event = $events[$id] ?? null;
        if (!$event) abort(404);

        return view('events.show', compact('event'));
    }
}
