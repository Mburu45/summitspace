@extends('layouts.public')

@section('content')
<div class="event-details">
    <div class="event-hero" style="background-image: url('{{ asset('images/' . ($event['image'] ?? 'event1.png')) }}');">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="event-icon">
                @if($event['category'] === 'Technology') 💻
                @elseif($event['category'] === 'Music') 🎵
                @elseif($event['category'] === 'Arts') 🎨
                @else 📅
                @endif
            </div>
            <h1>{{ $event['title'] }}</h1>
            <p>{{ $event['description'] }}</p>
        </div>
    </div>

    <div class="section">
        <h2>Event Details</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 2rem;">
            <div>
                <h3 style="color: var(--accent-color);">📅 Date & Time</h3>
                <p>{{ \Carbon\Carbon::parse($event['date'])->format('l, F j, Y') }}</p>
            </div>
            <div>
                <h3 style="color: var(--accent-color);">📍 Location</h3>
                <p>{{ $event['location'] }}</p>
            </div>
            <div>
                <h3 style="color: var(--accent-color);">💰 Price</h3>
                <p>{{ $event['price'] }}</p>
            </div>
            <div>
                <h3 style="color: var(--accent-color);">⭐ Rating</h3>
                <p>{{ $event['rating'] }} ({{ $event['attendees'] }} attending)</p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            @auth
                @if($event['id'] <= 4) <!-- Only for hardcoded events for now -->
                    <a href="{{ route('bookings.create', $event['id']) }}" class="cta-btn primary" style="margin-right: 1rem;">Book Now</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="cta-btn primary" style="margin-right: 1rem;">Login to Book</a>
            @endauth
            <a href="{{ route('events.index') }}" class="cta-btn secondary">Back to Events</a>
        </div>
    </div>
</div>
@endsection
