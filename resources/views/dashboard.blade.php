@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; background: var(--background-dark); padding: 2rem 0;">
    <div class="container">
        <div class="text-center mb-5 fade-in">
            <h1 style="color: var(--accent-color); margin-bottom: 0.5rem; font-size: 2.5rem;">Welcome to SummitSpace</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Discover amazing events and book your tickets with ease.</p>
        </div>

        <!-- User Stats Row -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="event-card fade-in" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; color: var(--accent-color); margin-bottom: 1rem;">🎫</div>
                    <h2 style="color: var(--accent-color); font-size: 2.5rem; margin-bottom: 0.5rem;">{{ auth()->user()->bookings()->count() }}</h2>
                    <h4 style="color: var(--text-light); margin-bottom: 0.5rem;">My Bookings</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Events you've booked</p>
                    <a href="{{ route('bookings.index') }}" class="learn-btn" style="margin-top: 1rem; text-decoration: none; display: inline-block;">View Bookings</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="event-card fade-in" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; color: var(--accent-purple); margin-bottom: 1rem;">⭐</div>
                    <h2 style="color: var(--accent-purple); font-size: 2.5rem; margin-bottom: 0.5rem;">4.8</h2>
                    <h4 style="color: var(--text-light); margin-bottom: 0.5rem;">Average Rating</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Based on your experience</p>
                    <a href="{{ route('events.index') }}" class="cta-btn primary" style="margin-top: 1rem; text-decoration: none; display: inline-block;">Browse Events</a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="event-card fade-in" style="padding: 2rem; margin-bottom: 2rem;">
            <h3 style="color: var(--accent-color); margin-bottom: 1.5rem;">Recent Activity</h3>
            @if(auth()->user()->bookings()->count() > 0)
                <div style="display: grid; gap: 1rem;">
                    @foreach(auth()->user()->bookings()->with('event')->latest()->take(3) as $booking)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(255, 255, 255, 0.05); border-radius: 8px;">
                            <div>
                                <h5 style="color: var(--text-light); margin: 0;">{{ $booking->event->title }}</h5>
                                <p style="color: var(--text-muted); margin: 0.5rem 0 0 0; font-size: 0.9rem;">
                                    📅 {{ \Carbon\Carbon::parse($booking->event->event_date)->format('M j, Y') }} •
                                    📍 {{ $booking->event->location }}
                                </p>
                            </div>
                            <div style="text-align: right;">
                                <span style="color: var(--accent-orange); font-weight: bold;">KSH {{ number_format($booking->total_amount, 0) }}</span>
                                <br>
                                <span style="color: var(--text-muted); font-size: 0.8rem;">{{ ucfirst($booking->status) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🎭</div>
                    <h4>No bookings yet</h4>
                    <p>Start exploring events and make your first booking!</p>
                    <a href="{{ route('events.index') }}" class="cta-btn primary" style="margin-top: 1rem; text-decoration: none; display: inline-block;">Explore Events</a>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="text-center fade-in">
            <h3 style="color: var(--text-light); margin-bottom: 2rem;">Quick Actions</h3>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('events.index') }}" class="cta-btn primary" style="text-decoration: none;">Browse Events</a>
                <a href="{{ route('bookings.index') }}" class="cta-btn secondary" style="text-decoration: none;">My Bookings</a>
                <a href="{{ route('profile.edit') }}" class="learn-btn" style="text-decoration: none;">Edit Profile</a>
            </div>
        </div>
    </div>
</div>
@endsection
