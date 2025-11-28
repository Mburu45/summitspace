@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Booking: {{ $booking->event->title }}</h2>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Event Details</h5>
                            <p><strong>Date:</strong> {{ $booking->event->event_date->format('l, F j, Y') }}</p>
                            <p><strong>Location:</strong> {{ $booking->event->location }}</p>
                            <p><strong>Price per person:</strong> KSh {{ number_format($booking->event->price, 2) }}</p>
                            <p><strong>Available spots:</strong> {{ $booking->event->available_spots + $booking->number_of_guests }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Current Booking</h5>
                            <p><strong>Guests:</strong> {{ $booking->number_of_guests }}</p>
                            <p><strong>Total Amount:</strong> KSh {{ number_format($booking->total_amount, 2) }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge
                                    @if($booking->status === 'approved') bg-success
                                    @elseif($booking->status === 'pending') bg-warning
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('bookings.update', $booking) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="booking_date" class="form-label">Preferred Booking Date</label>
                                <input type="date" class="form-control @error('booking_date') is-invalid @enderror"
                                       id="booking_date" name="booking_date"
                                       value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}"
                                       min="{{ today()->format('Y-m-d') }}" required>
                                @error('booking_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="number_of_guests" class="form-label">Number of Guests</label>
                                <input type="number" class="form-control @error('number_of_guests') is-invalid @enderror"
                                       id="number_of_guests" name="number_of_guests"
                                       value="{{ old('number_of_guests', $booking->number_of_guests) }}"
                                       min="1" max="{{ $booking->event->available_spots + $booking->number_of_guests }}" required>
                                @error('number_of_guests')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="special_requests" class="form-label">Special Requests (Optional)</label>
                            <textarea class="form-control @error('special_requests') is-invalid @enderror"
                                      id="special_requests" name="special_requests" rows="3"
                                      placeholder="Any special requirements or notes...">{{ old('special_requests', $booking->special_requests) }}</textarea>
                            @error('special_requests')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 p-3 bg-light rounded">
                            <h5>New Total Amount: <span id="total-amount">KSh {{ number_format($booking->total_amount, 2) }}</span></h5>
                            <small class="text-muted">Amount will be recalculated based on new number of guests</small>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const guestsInput = document.getElementById('number_of_guests');
    const totalAmountSpan = document.getElementById('total-amount');
    const pricePerPerson = {{ $booking->event->price }};

    function updateTotal() {
        const guests = parseInt(guestsInput.value) || {{ $booking->number_of_guests }};
        const total = guests * pricePerPerson;
        totalAmountSpan.textContent = 'KSh ' + total.toLocaleString('en-KE', { minimumFractionDigits: 2 });
    }

    guestsInput.addEventListener('input', updateTotal);
    updateTotal(); // Initial calculation
});
</script>
@endsection