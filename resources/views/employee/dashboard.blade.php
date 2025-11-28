@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; background: var(--background-dark); padding: 2rem 0;">
    <div class="container">
        <div class="text-center mb-5 fade-in">
            <h1 style="color: var(--accent-color); margin-bottom: 0.5rem; font-size: 2.5rem;">Employee Dashboard</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Manage events and track your performance as an event organizer.</p>
        </div>

        <!-- Employee Stats Row -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="event-card fade-in" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; color: var(--accent-color); margin-bottom: 1rem;">📅</div>
                    <h2 style="color: var(--accent-color); font-size: 2.5rem; margin-bottom: 0.5rem;">
                        {{ \App\Models\Event::where('created_by', auth()->id())->count() }}
                    </h2>
                    <h4 style="color: var(--text-light); margin-bottom: 0.5rem;">My Events</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Events you've created</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="event-card fade-in" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; color: var(--accent-purple); margin-bottom: 1rem;">🎫</div>
                    <h2 style="color: var(--accent-purple); font-size: 2.5rem; margin-bottom: 0.5rem;">
                        {{ \App\Models\Booking::whereHas('event', function($q) {
                            $q->where('created_by', auth()->id());
                        })->where('status', 'approved')->count() }}
                    </h2>
                    <h4 style="color: var(--text-light); margin-bottom: 0.5rem;">Tickets Sold</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Bookings for your events</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="event-card fade-in" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; color: var(--accent-orange); margin-bottom: 1rem;">💰</div>
                    <h2 style="color: var(--accent-orange); font-size: 2.5rem; margin-bottom: 0.5rem;">KSH {{
                        number_format(\App\Models\Booking::whereHas('event', function($q) {
                            $q->where('created_by', auth()->id());
                        })->where('status', 'approved')->sum('total_amount'), 0)
                    }}</h2>
                    <h4 style="color: var(--text-light); margin-bottom: 0.5rem;">Revenue</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Total earnings from events</p>
                </div>
            </div>
        </div>

        <!-- Recent Events -->
        <div class="event-card fade-in" style="padding: 2rem; margin-bottom: 2rem;">
            <h3 style="color: var(--accent-color); margin-bottom: 1.5rem;">My Recent Events</h3>
            @php
                $recentEvents = \App\Models\Event::where('created_by', auth()->id())
                    ->withCount('bookings')
                    ->latest()
                    ->take(5)
                    ->get();
            @endphp

            @if($recentEvents->count() > 0)
                <div style="display: grid; gap: 1rem;">
                    @foreach($recentEvents as $event)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(255, 255, 255, 0.05); border-radius: 8px;">
                            <div>
                                <h5 style="color: var(--text-light); margin: 0;">{{ $event->title }}</h5>
                                <p style="color: var(--text-muted); margin: 0.5rem 0 0 0; font-size: 0.9rem;">
                                    📅 {{ \Carbon\Carbon::parse($event->event_date)->format('M j, Y') }} •
                                    📍 {{ $event->location }} •
                                    🎫 {{ $event->bookings_count }} bookings
                                </p>
                            </div>
                            <div style="text-align: right;">
                                <span style="color: var(--accent-orange); font-weight: bold;">KSH {{ number_format($event->price, 0) }}</span>
                                <br>
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="learn-btn" style="font-size: 0.8rem; padding: 0.3rem 0.6rem; text-decoration: none; margin-top: 0.5rem; display: inline-block;">Edit</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🎪</div>
                    <h4>No events created yet</h4>
                    <p>Start creating amazing events for attendees!</p>
                    <a href="{{ route('admin.events.create') }}" class="cta-btn primary" style="margin-top: 1rem; text-decoration: none; display: inline-block;">Create First Event</a>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="text-center fade-in">
            <h3 style="color: var(--text-light); margin-bottom: 2rem;">Quick Actions</h3>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('admin.events.create') }}" class="cta-btn primary" style="text-decoration: none;">Create Event</a>
                <a href="{{ route('admin.events.index') }}" class="cta-btn secondary" style="text-decoration: none;">Manage Events</a>
                <a href="{{ route('reports.index') }}" class="learn-btn" style="text-decoration: none;">View Reports</a>
            </div>
        </div>
    </div>
</div>
@endsection