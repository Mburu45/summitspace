<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmation;
use App\Models\Booking;
use App\Models\Event;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Display a listing of the user's bookings.
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Request $request, $eventId)
    {
        // Get event from database
        $event = Event::findOrFail($eventId);

        // Check if user already has a booking for this event
        $existingBooking = Auth::user()->bookings()
            ->where('event_id', $eventId)
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'You already have a booking for this event.');
        }

        return view('bookings.create', ['event' => $event, 'eventId' => $eventId]);
    }

    /**
     * Get hardcoded events (temporary until we have database events)
     */
    private function getHardcodedEvents()
    {
        return [
            1 => [
                'id' => 1,
                'title' => 'Fifa tournament',
                'date' => '2024-11-01',
                'location' => 'Nairobi, Kenya, Gamers Hub',
                'category' => 'Technology',
                'description' => 'Annual technology conference featuring the latest innovations',
                'price' => 15000,
                'image' => '/images/event1.png',
                'attendees' => 500,
                'rating' => 4.8,
                'capacity' => 1000
            ],
            2 => [
                'id' => 2,
                'title' => 'Jazz Night Live',
                'date' => '2024-11-20',
                'location' => 'KICC, Nairobi, Kenya',
                'category' => 'Music',
                'description' => 'An evening of smooth jazz with renowned musicians',
                'price' => 10000,
                'image' => '/images/event2.png',
                'attendees' => 200,
                'rating' => 4.9,
                'capacity' => 500
            ],
            3 => [
                'id' => 3,
                'title' => 'Hackathon 2024',
                'date' => '2024-12-05',
                'location' => 'Kenyatta University, Nairobi, Kenya',
                'category' => 'Technology',
                'description' => '48-hour coding competition with amazing prizes',
                'price' => 20000,
                'image' => '/images/event3.png',
                'attendees' => 300,
                'rating' => 4.7,
                'capacity' => 200
            ],
            4 => [
                'id' => 4,
                'title' => 'Art Gallery Opening',
                'date' => '2024-09-30',
                'location' => 'Nairobi National Museum, Nairobi, Kenya',
                'category' => 'Arts',
                'description' => 'Contemporary art exhibition featuring local artists',
                'price' => 15000,
                'image' => '/images/event1.png',
                'attendees' => 150,
                'rating' => 4.5,
                'capacity' => 300
            ]
        ];
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'number_of_guests' => 'required|integer|min:1|max:' . $event->available_spots,
            'special_requests' => 'nullable|string|max:500',
            'phone' => 'required|string|regex:/^254[0-9]{9}$/',
            'email' => 'required|email',
            'send_email_confirmation' => 'nullable|boolean',
        ]);

        // Check if user already has a booking for this event
        $existingBooking = Auth::user()->bookings()
            ->where('event_id', $eventId)
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'You already have a booking for this event.');
        }

        $totalAmount = $event->price * $request->number_of_guests;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'event_id' => $eventId,
            'booking_date' => $request->booking_date,
            'number_of_guests' => $request->number_of_guests,
            'special_requests' => $request->special_requests,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // Send email confirmation if requested
        if ($request->boolean('send_email_confirmation')) {
            try {
                Mail::to($request->email)->send(new BookingConfirmation($booking));
            } catch (\Exception $e) {
                // Log email error but don't fail the booking
                \Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
            }
        }

        // Initiate M-Pesa payment
        $mpesaService = new MpesaService();
        $paymentResult = $mpesaService->stkPush(
            $request->phone,
            $totalAmount,
            'BK' . $booking->id, // Account reference
            'Event Booking Payment - ' . $event->title
        );

        if ($paymentResult['success']) {
            // Update booking with payment details
            $booking->update([
                'mpesa_receipt_number' => $paymentResult['checkout_request_id'] ?? null,
                'transaction_status' => 'initiated',
            ]);

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Payment request sent to your phone. Please complete the payment to confirm your booking.');
        } else {
            // Payment failed, cancel booking
            $booking->update(['status' => 'cancelled']);

            return redirect()->back()
                ->with('error', 'Failed to initiate payment. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        // Ensure user can only view their own bookings (unless admin)
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $booking->load('event', 'user');
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        // Only allow editing pending bookings
        if ($booking->user_id !== Auth::id() || $booking->status !== 'pending') {
            abort(403);
        }

        $booking->load('event');
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        // Only allow updating pending bookings
        if ($booking->user_id !== Auth::id() || $booking->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'number_of_guests' => 'required|integer|min:1|max:' . ($booking->event->available_spots + $booking->number_of_guests),
            'special_requests' => 'nullable|string|max:500',
        ]);

        $totalAmount = $booking->event->price * $request->number_of_guests;

        $booking->update([
            'booking_date' => $request->booking_date,
            'number_of_guests' => $request->number_of_guests,
            'special_requests' => $request->special_requests,
            'total_amount' => $totalAmount,
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking updated successfully!');
    }

    /**
     * Cancel the specified booking.
     */
    public function destroy(Booking $booking)
    {
        // Only allow cancelling pending or approved bookings
        if ($booking->user_id !== Auth::id() ||
            !in_array($booking->status, ['pending', 'approved'])) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully!');
    }

    /**
     * Admin: List all bookings
     */
    public function adminIndex(Request $request)
    {
        $bookings = Booking::with('user', 'event')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, function($q) use ($request) {
                $q->whereHas('user', fn($user) => $user->where('name', 'like', '%' . $request->search . '%'))
                  ->orWhereHas('event', fn($event) => $event->where('title', 'like', '%' . $request->search . '%'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Admin: Update booking status
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $booking->update([
            'status' => $request->status,
            'approved_at' => $request->status === 'approved' ? now() : null,
        ]);

        return redirect()->back()->with('success', 'Booking status updated successfully!');
    }

    /**
     * Handle M-Pesa callback
     */
    public function mpesaCallback(Request $request)
    {
        $mpesaService = new MpesaService();
        return $mpesaService->handleCallback($request->all());
    }
}
