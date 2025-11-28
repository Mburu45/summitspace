@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Booking Details</h2>
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
                    <!-- Event Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Event Information</h5>
                            <p><strong>Event:</strong> {{ $booking->event->title }}</p>
                            <p><strong>Date:</strong> {{ $booking->event->event_date->format('l, F j, Y') }}</p>
                            <p><strong>Location:</strong> {{ $booking->event->location }}</p>
                            <p><strong>Price per person:</strong> KSh {{ number_format($booking->event->price, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Booking Information</h5>
                            <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
                            <p><strong>Booking Date:</strong> {{ $booking->created_at->format('M j, Y \a\t g:i A') }}</p>
                            <p><strong>Number of Guests:</strong> {{ $booking->number_of_guests }}</p>
                            <p><strong>Total Amount:</strong> KSh {{ number_format($booking->total_amount, 2) }}</p>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>Payment Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Payment Status:</strong>
                                        <span class="badge
                                            @if($booking->payment_status === 'paid') bg-success
                                            @elseif($booking->payment_status === 'pending') bg-warning
                                            @elseif($booking->payment_status === 'failed') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($booking->payment_status ?? 'pending') }}
                                        </span>
                                    </p>
                                    @if($booking->mpesa_receipt_number)
                                        <p><strong>M-Pesa Reference:</strong> {{ $booking->mpesa_receipt_number }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Transaction Status:</strong>
                                        <span class="badge
                                            @if($booking->transaction_status === 'completed') bg-success
                                            @elseif($booking->transaction_status === 'initiated') bg-info
                                            @elseif($booking->transaction_status === 'failed') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($booking->transaction_status ?? 'pending') }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Special Requests -->
                    @if($booking->special_requests)
                    <div class="mb-4">
                        <h5>Special Requests</h5>
                        <p>{{ $booking->special_requests }}</p>
                    </div>
                    @endif

                    <!-- Status Messages -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                            @if(str_contains(session('success'), 'Payment request sent'))
                                <div class="mt-2">
                                    <small><i class="fas fa-envelope text-info me-1"></i>A booking confirmation email has been sent to your email address.</small>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back to My Bookings</a>

                        @if($booking->status === 'pending' && $booking->payment_status !== 'paid')
                            <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-primary">Edit Booking</a>
                        @endif

                        @if(in_array($booking->status, ['pending', 'approved']))
                            <form method="POST" action="{{ route('bookings.destroy', $booking) }}"
                                  onsubmit="return confirm('Are you sure you want to cancel this booking?')"
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Cancel Booking</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            @if($booking->payment_status === 'pending' && $booking->transaction_status === 'initiated')
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="text-warning">⚠️ Payment Pending</h5>
                    <p>A payment request has been sent to your M-Pesa registered phone number. Please complete the payment to confirm your booking.</p>
                    <ul>
                        <li>Check your phone for the M-Pesa payment prompt</li>
                        <li>Enter your M-Pesa PIN to complete the transaction</li>
                        <li>Your booking will be confirmed once payment is received</li>
                    </ul>
                </div>
            </div>
            @endif

            <!-- Booking Confirmed -->
            @if($booking->status === 'approved' && $booking->payment_status === 'paid')
            <div class="card mt-4 border-success">
                <div class="card-body text-center">
                    <h5 class="text-success">✅ Booking Confirmed!</h5>
                    <p>Your booking has been confirmed and payment received. You will receive further details closer to the event date.</p>
                    <div class="mt-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection