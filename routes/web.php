<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Redirect /dashboard Breeze berdasarkan Role
Route::get('/dashboard', function () {
    if (auth()->user() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('customer.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// ROUTE USER / PENONTON
Route::middleware(['auth'])->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('customer.index');
    Route::get('/event/{id}', [OrderController::class, 'show'])->name('events.show');
    Route::get('/ticket/{id}', [OrderController::class, 'show'])->name('tickets.show');
    Route::post('/checkout', [OrderController::class, 'store'])->name('customer.checkout');
});

// ROUTE ADMIN & PROFILE
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [OrderController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::resource('tickets', TicketController::class)->names('admin.tickets');
    });
});

require __DIR__.'/auth.php';
