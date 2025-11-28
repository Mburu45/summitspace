<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Show dashboard page
    public function dashboard()
    {
        // These counts replace your React mock data
        $totalEvents = Event::count();
        $totalUsers = User::count();

        // Count approved bookings
        $ticketsSold = Booking::where('status', 'approved')->count();

        return view('admin.dashboard', compact('totalEvents', 'totalUsers', 'ticketsSold'));
    }
}
