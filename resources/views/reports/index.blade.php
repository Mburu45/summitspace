@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Reports Dashboard</h1>
            <p class="text-muted mb-4">Generate and view comprehensive reports for your event management system.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Events Report -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="background: var(--secondary-color); color: white;">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-calendar-alt" style="font-size: 3rem; color: var(--accent-color);"></i>
                    </div>
                    <h5 class="card-title">Events Report</h5>
                    <p class="card-text">View event creation and booking statistics</p>
                    <a href="{{ route('reports.events') }}" class="btn btn-primary">Generate Report</a>
                </div>
            </div>
        </div>

        <!-- Bookings Report -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="background: var(--secondary-color); color: white;">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-ticket-alt" style="font-size: 3rem; color: var(--accent-color);"></i>
                    </div>
                    <h5 class="card-title">Bookings Report</h5>
                    <p class="card-text">Analyze booking trends and status</p>
                    <a href="{{ route('reports.bookings') }}" class="btn btn-primary">Generate Report</a>
                </div>
            </div>
        </div>

        <!-- Users Report -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="background: var(--secondary-color); color: white;">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-users" style="font-size: 3rem; color: var(--accent-color);"></i>
                    </div>
                    <h5 class="card-title">Users Report</h5>
                    <p class="card-text">User registration and role statistics</p>
                    <a href="{{ route('reports.users') }}" class="btn btn-primary">Generate Report</a>
                </div>
            </div>
        </div>

        <!-- Financial Report -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="background: var(--secondary-color); color: white;">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-chart-line" style="font-size: 3rem; color: var(--accent-color);"></i>
                    </div>
                    <h5 class="card-title">Financial Report</h5>
                    <p class="card-text">Revenue analysis and financial insights</p>
                    <a href="{{ route('reports.financial') }}" class="btn btn-primary">Generate Report</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Quick Overview</h3>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="text-primary">{{ \App\Models\Event::count() }}</h2>
                    <p class="text-muted mb-0">Total Events</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="text-success">{{ \App\Models\Booking::where('status', 'approved')->count() }}</h2>
                    <p class="text-muted mb-0">Confirmed Bookings</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="text-info">{{ \App\Models\User::where('role', 'user')->count() }}</h2>
                    <p class="text-muted mb-0">Registered Users</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="text-warning">KSH {{ number_format(\App\Models\Booking::where('status', 'approved')->sum('total_amount'), 0) }}</h2>
                    <p class="text-muted mb-0">Total Revenue</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection