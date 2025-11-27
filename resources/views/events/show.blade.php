@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card">
        <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #6f42c1, #6610f2); font-size: 3rem;">
            @if($event['category'] === 'Technology') 💻 
            @elseif($event['category'] === 'Music') 🎵
            @elseif($event['category'] === 'Arts') 🎨
            @else 📅
            @endif
        </div>
        <div class="card-body">
            <h3 class="text-primary">{{ $event['title'] }}</h3>
            <p>{{ $event['description'] }}</p>
            <p>📅 {{ \Carbon\Carbon::parse($event['date'])->format('D, M j, Y') }}</p>
            <p>📍 {{ $event['location'] }}</p>
            <p>💰 Price: {{ $event['price'] }}</p>
            <p>⭐ Rating: {{ $event['rating'] }} ({{ $event['attendees'] }} attending)</p>
            <a href="{{ route('events.index') }}" class="btn btn-secondary mt-3">Back to Events</a>
        </div>
    </div>
</div>
@endsection
