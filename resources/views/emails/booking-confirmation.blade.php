<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - SummitSpace</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #6f42c1;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #6f42c1;
            margin-bottom: 10px;
        }
        .booking-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .event-info {
            border-left: 4px solid #6f42c1;
            padding-left: 15px;
            margin: 20px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-approved { background-color: #28a745; color: #fff; }
        .status-cancelled { background-color: #dc3545; color: #fff; }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .highlight {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">SummitSpace</div>
            <h1>Booking Confirmation</h1>
            <p>Thank you for booking with us!</p>
        </div>

        <div class="booking-details">
            <h3>Booking Details</h3>
            <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
            <p><strong>Booking Date:</strong> {{ $booking->created_at->format('F j, Y \a\t g:i A') }}</p>
            <p><strong>Status:</strong>
                <span class="status-badge status-{{ $booking->status }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </p>
        </div>

        <div class="event-info">
            <h3>Event Information</h3>
            <p><strong>Event:</strong> {{ $event->title }}</p>
            <p><strong>Date:</strong> {{ $event->event_date->format('l, F j, Y') }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Description:</strong> {{ $event->description ?? 'No description available.' }}</p>
        </div>

        <div class="booking-details">
            <h3>Your Booking</h3>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Number of Guests:</strong> {{ $booking->number_of_guests }}</p>
            <p><strong>Total Amount:</strong> KSh {{ number_format($booking->total_amount, 2) }}</p>
            @if($booking->special_requests)
                <p><strong>Special Requests:</strong> {{ $booking->special_requests }}</p>
            @endif
        </div>

        @if($booking->payment_status === 'pending')
        <div class="highlight">
            <h4>⚠️ Payment Required</h4>
            <p>Your booking is pending payment confirmation. Please complete your M-Pesa payment to secure your spot.</p>
            <p><strong>Payment Amount:</strong> KSh {{ number_format($booking->total_amount, 2) }}</p>
        </div>
        @elseif($booking->payment_status === 'paid')
        <div class="highlight" style="background-color: #d4edda; border: 1px solid #c3e6cb;">
            <h4>✅ Payment Confirmed</h4>
            <p>Your payment has been received successfully. Your booking is now confirmed!</p>
        </div>
        @endif

        <div class="booking-details">
            <h4>What's Next?</h4>
            <ul>
                <li>Keep this email for your records</li>
                <li>You can view your booking details anytime in your dashboard</li>
                <li>You'll receive updates about the event closer to the date</li>
                <li>Arrive at the venue 30 minutes before the event starts</li>
            </ul>
        </div>

        <div class="footer">
            <p>
                <strong>SummitSpace</strong><br>
                Where Ideas and Events Rise<br>
                Questions? Contact us at info@summitspace.com
            </p>
            <p style="margin-top: 15px; font-size: 12px;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>