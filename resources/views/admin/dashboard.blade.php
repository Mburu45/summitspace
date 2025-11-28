@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; background: var(--background-dark); padding: 2rem 0;">
    <div class="container">
        <div class="text-center mb-5 fade-in">
            <h1 style="color: var(--accent-color); margin-bottom: 0.5rem; font-size: 2.5rem;">Admin Dashboard</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Welcome back, Administrator! Here's your system overview.</p>
        </div>

        <!-- Quick Stats Row -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="event-card fade-in" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; color: var(--accent-color); margin-bottom: 1rem;">📅</div>
                    <h2 style="color: var(--accent-color); font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalEvents }}</h2>
                    <h4 style="color: var(--text-light); margin-bottom: 0.5rem;">Total Events</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Events created in the system</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="event-card fade-in" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; color: var(--accent-purple); margin-bottom: 1rem;">👥</div>
                    <h2 style="color: var(--accent-purple); font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalUsers }}</h2>
                    <h4 style="color: var(--text-light); margin-bottom: 0.5rem;">Registered Users</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Active user accounts</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="event-card fade-in" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; color: var(--accent-orange); margin-bottom: 1rem;">🎫</div>
                    <h2 style="color: var(--accent-orange); font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $ticketsSold }}</h2>
                    <h4 style="color: var(--text-light); margin-bottom: 0.5rem;">Tickets Sold</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Total bookings completed</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="text-center fade-in">
            <h3 style="color: var(--text-light); margin-bottom: 2rem;">Quick Actions</h3>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('admin.events.create') }}" class="cta-btn primary" style="text-decoration: none;">Create Event</a>
                <a href="{{ route('reports.index') }}" class="cta-btn secondary" style="text-decoration: none;">View Reports</a>
                <a href="{{ route('admin.events.index') }}" class="learn-btn" style="text-decoration: none;">Manage Events</a>
            </div>
        </div>
    </div>
</div>
@endsection
