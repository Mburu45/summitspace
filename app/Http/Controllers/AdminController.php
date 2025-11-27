<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
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

        // Example: assuming you will later create a tickets table
        $ticketsSold = DB::table('tickets')->count();

        return view('admin.dashboard', compact('totalEvents', 'totalUsers', 'ticketsSold'));
    }
}
