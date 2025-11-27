@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="text-primary mb-2">Discover Amazing Events</h1>
        <p class="text-muted">Find and attend the best events in your area</p>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" class="d-flex justify-content-center gap-2 flex-wrap mb-4">
        <input type="text" name="search" value="{{ $searchTerm }}" placeholder="Search events..." class="form-control" style="max-width: 250px;">
        <select name="category" class="form-control">
            <option value="all">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category }}" {{ $filterCategory === $category ? 'selected' : '' }}>{{ $category }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    {{-- Events Grid --}}
    @if(count($filteredEvents) === 0)
        <div class="text-center py-5">
            <h3>No events found matching your criteria</h3>
            <p>Try adjusting your search or filter settings</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($filteredEvents as $event)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #6f42c1, #6610f2); font-size: 3rem;">
                        @if($event['category'] === 'Technology') 💻 
                        @elseif($event['category'] === 'Music') 🎵
                        @elseif($event['category'] === 'Arts') 🎨
                        @else 📅
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary">{{ $event['title'] }}</h5>
                        <p class="card-text text-muted" style="font-size: 0.9rem;">{{ $event['description'] }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-warning">{{ $event['price'] }}</span>
                            <span class="text-muted" style="font-size: 0.8rem;">⭐ {{ $event['rating'] }} ({{ $event['attendees'] }} attending)</span>
                        </div>
                        <p class="mb-1" style="font-size: 0.9rem;">📅 {{ \Carbon\Carbon::parse($event['date'])->format('D, M j, Y') }}</p>
                        <p style="font-size: 0.9rem;">📍 {{ $event['location'] }}</p>
                        <a href="{{ route('events.show', $event['id']) }}" class="btn btn-primary mt-auto">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    {{-- CTA --}}
    <div class="text-center mt-5">
        <h2>Can't Find What You're Looking For?</h2>
        <p>Check back later for more exciting events or contact us to suggest new ones!</p>
        <a href="{{ route('register') }}" class="btn btn-primary">Get Event Updates</a>
    </div>
</div>
@endsection
