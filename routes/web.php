<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\BookingController;

// Include auth routes
require __DIR__.'/auth.php';

// ----------------------------------------------------------
// 🌍 PUBLIC ROUTES (Visible to everyone)
// ----------------------------------------------------------
Route::get('/', fn() => view('welcome'))->name('welcome');
Route::get('/home', fn() => view('home'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');

// 📰 Events Page
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// ----------------------------------------------------------
// 🔒 AUTHENTICATED ROUTES
// ----------------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // 🧭 Redirect users to dashboard based on role
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // User profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User bookings
    Route::get('bookings/create/{eventId}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings/{eventId}', [BookingController::class, 'store'])->name('bookings.store');
    Route::resource('bookings', BookingController::class)->except(['create', 'store']);

    // Admin/Employee routes
    Route::middleware(['can:isAdminOrEmployee'])->group(function () {
        // Event management
        Route::get('/admin/events', [AdminEventController::class, 'index'])->name('admin.events.index');
        Route::get('/admin/events/create', [AdminEventController::class, 'create'])->name('admin.events.create');
        Route::post('/admin/events', [AdminEventController::class, 'store'])->name('admin.events.store');
        Route::get('/admin/events/{id}/edit', [AdminEventController::class, 'edit'])->name('admin.events.edit');
        Route::put('/admin/events/{id}', [AdminEventController::class, 'update'])->name('admin.events.update');
        Route::delete('/admin/events/{id}', [AdminEventController::class, 'destroy'])->name('admin.events.destroy');

        // Booking management
        Route::get('/admin/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings.index');
        Route::patch('/admin/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.update-status');

        // Reports
        Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
        Route::get('/reports/events', [ReportsController::class, 'eventsReport'])->name('reports.events');
        Route::get('/reports/bookings', [ReportsController::class, 'bookingsReport'])->name('reports.bookings');
        Route::get('/reports/users', [ReportsController::class, 'usersReport'])->name('reports.users');
        Route::get('/reports/financial', [ReportsController::class, 'financialReport'])->name('reports.financial');
    });
});

// ----------------------------------------------------------
// 🔑 AUTH ROUTES (Login / Register / Logout)
// ----------------------------------------------------------
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');

Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.post');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// M-Pesa callback route
Route::post('/api/mpesa/callback', [BookingController::class, 'mpesaCallback'])->name('mpesa.callback');

// Booking routes
Route::middleware(['auth'])->group(function () {
    Route::resource('bookings', BookingController::class)->except(['create']);
    Route::get('events/{eventId}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
});
