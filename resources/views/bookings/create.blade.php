@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Book Event: {{ $event->title }}</h2>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Event Details</h5>
                            <p><strong>Date:</strong> {{ $event->event_date->format('l, F j, Y') }}</p>
                            <p><strong>Location:</strong> {{ $event->location }}</p>
                            <p><strong>Price per person:</strong> KSh {{ number_format($event->price, 2) }}</p>
                            <p><strong>Available spots:</strong> {{ $event->available_spots }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Description</h5>
                            <p>{{ $event->description ?? 'No description available.' }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('bookings.store', $eventId) }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="booking_date" class="form-label">Preferred Booking Date</label>
                                <input type="date" class="form-control @error('booking_date') is-invalid @enderror"
                                       id="booking_date" name="booking_date"
                                       value="{{ old('booking_date', today()->format('Y-m-d')) }}"
                                       min="{{ today()->format('Y-m-d') }}" required>
                                @error('booking_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="number_of_guests" class="form-label">Number of Guests</label>
                                <input type="number" class="form-control @error('number_of_guests') is-invalid @enderror"
                                       id="number_of_guests" name="number_of_guests"
                                       value="{{ old('number_of_guests', 1) }}"
                                       min="1" max="{{ $event->available_spots }}" required>
                                @error('number_of_guests')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="special_requests" class="form-label">Special Requests (Optional)</label>
                                <textarea class="form-control @error('special_requests') is-invalid @enderror"
                                          id="special_requests" name="special_requests" rows="3"
                                          placeholder="Any special requirements or notes...">{{ old('special_requests') }}</textarea>
                                @error('special_requests')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email"
                                       value="{{ old('email', auth()->user()->email ?? '') }}"
                                       placeholder="your@email.com" required>
                                <small class="form-text text-muted">We'll send booking confirmation to this email</small>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">M-Pesa Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone"
                                       value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                       placeholder="254712345678" required>
                                <small class="form-text text-muted">Enter your M-Pesa registered phone number (254XXXXXXXXX)</small>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="send_email_confirmation" name="send_email_confirmation" checked>
                                    <label class="form-check-label" for="send_email_confirmation">
                                        Send booking confirmation email
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 p-3 bg-light rounded">
                            <h5>Total Amount: <span id="total-amount">KSh {{ number_format($event->price, 2) }}</span></h5>
                            <small class="text-muted">Amount will be calculated based on number of guests</small>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success" id="pay-btn">
                                <i class="fas fa-mobile-alt me-2"></i>Pay Now with M-Pesa
                            </button>
                            <a href="{{ route('events.show', $event) }}" class="btn btn-secondary">Back to Event</a>
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
    const payBtn = document.getElementById('pay-btn');
    const pricePerPerson = {{ $event->price }};

    function updateTotal() {
        const guests = parseInt(guestsInput.value) || 1;
        const total = guests * pricePerPerson;
        totalAmountSpan.textContent = 'KSh ' + total.toLocaleString('en-KE', { minimumFractionDigits: 2 });
    }

    function showLoading() {
        payBtn.disabled = true;
        payBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing Payment...';
    }

    guestsInput.addEventListener('input', updateTotal);
    payBtn.addEventListener('click', showLoading);
    updateTotal(); // Initial calculation
});
</script>
@endsection