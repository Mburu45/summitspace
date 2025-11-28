@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-2">My Bookings</h1>
            <p class="text-muted">Manage your event bookings</p>
        </div>
        <a href="{{ route('events.index') }}" class="btn btn-primary">Browse Events</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($bookings->count() > 0)
        <div class="row g-4">
            @foreach($bookings as $booking)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $booking->event->title }}</h5>
                        <span class="badge
                            @if($booking->status === 'approved') bg-success
                            @elseif($booking->status === 'pending') bg-warning
                            @elseif($booking->status === 'cancelled') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Date:</strong> {{ $booking->event->event_date->format('M j, Y') }}</p>
                        <p class="mb-2"><strong>Location:</strong> {{ $booking->event->location }}</p>
                        <p class="mb-2"><strong>Guests:</strong> {{ $booking->number_of_guests }}</p>
                        <p class="mb-2"><strong>Total:</strong> KSh {{ number_format($booking->total_amount, 2) }}</p>
                        <p class="mb-3"><strong>Booked:</strong> {{ $booking->created_at->format('M j, Y') }}</p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-primary btn-sm">View Details</a>

                            @if($booking->status === 'pending' && $booking->payment_status !== 'paid')
                                <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                            @endif

                            @if(in_array($booking->status, ['pending', 'approved']))
                                <form method="POST" action="{{ route('bookings.destroy', $booking) }}"
                                      onsubmit="return confirm('Are you sure you want to cancel this booking?')"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Cancel</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $bookings->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-calendar-times text-muted" style="font-size: 4rem;"></i>
            </div>
            <h3 class="text-muted">No Bookings Yet</h3>
            <p class="text-muted mb-4">You haven't made any event bookings yet. Start exploring amazing events!</p>
            <a href="{{ route('events.index') }}" class="btn btn-primary">Browse Events</a>
        </div>
    @endif
</div>
@endsection