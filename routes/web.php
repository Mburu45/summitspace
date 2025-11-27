<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\UserController;

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

    // Admin event management
    Route::middleware(['can:isAdmin'])->group(function () {
        Route::get('/admin/events', [AdminEventController::class, 'index'])->name('admin.events.index');
        Route::get('/admin/events/create', [AdminEventController::class, 'create'])->name('admin.events.create');
        Route::post('/admin/events', [AdminEventController::class, 'store'])->name('admin.events.store');
        Route::get('/admin/events/{id}/edit', [AdminEventController::class, 'edit'])->name('admin.events.edit');
        Route::put('/admin/events/{id}', [AdminEventController::class, 'update'])->name('admin.events.update');
        Route::delete('/admin/events/{id}', [AdminEventController::class, 'destroy'])->name('admin.events.destroy');
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
