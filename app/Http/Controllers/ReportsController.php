<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function eventsReport(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->addDays(30)->format('Y-m-d'));

        $events = Event::whereBetween('created_at', [$startDate, $endDate])
            ->withCount('bookings')
            ->get();

        $totalEvents = $events->count();
        $totalBookings = $events->sum('bookings_count');
        $totalRevenue = $events->sum(function ($event) {
            return $event->bookings_count * $event->price;
        });

        return view('reports.events', compact('events', 'totalEvents', 'totalBookings', 'totalRevenue', 'startDate', 'endDate'));
    }

    public function bookingsReport(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->addDays(30)->format('Y-m-d'));

        $bookings = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->with(['user', 'event'])
            ->get();

        $totalBookings = $bookings->count();
        $confirmedBookings = $bookings->where('status', 'approved')->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $cancelledBookings = $bookings->where('status', 'cancelled')->count();
        $totalRevenue = $bookings->where('status', 'approved')->sum('total_amount');

        return view('reports.bookings', compact(
            'bookings', 'totalBookings', 'confirmedBookings', 'pendingBookings',
            'cancelledBookings', 'totalRevenue', 'startDate', 'endDate'
        ));
    }

    public function usersReport(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->addDays(30)->format('Y-m-d'));

        $users = User::whereBetween('created_at', [$startDate, $endDate])->get();

        $totalUsers = $users->count();
        $adminUsers = $users->where('role', 'admin')->count();
        $employeeUsers = $users->where('role', 'employee')->count();
        $regularUsers = $users->where('role', 'user')->count();

        return view('reports.users', compact(
            'users', 'totalUsers', 'adminUsers', 'employeeUsers',
            'regularUsers', 'startDate', 'endDate'
        ));
    }

    public function financialReport(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->addDays(30)->format('Y-m-d'));

        $bookings = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'approved')
            ->with('event')
            ->get();

        $totalRevenue = $bookings->sum('total_amount');
        $totalBookings = $bookings->count();

        // Revenue by event
        $revenueByEvent = $bookings->groupBy('event.title')->map(function ($group) {
            return [
                'event' => $group->first()->event->title,
                'revenue' => $group->sum('total_amount'),
                'bookings' => $group->count()
            ];
        });

        return view('reports.financial', compact(
            'totalRevenue', 'totalBookings', 'revenueByEvent', 'startDate', 'endDate'
        ));
    }
}
