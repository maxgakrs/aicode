<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CostumeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/costumes', [CostumeController::class, 'index'])->name('costumes.index');
Route::get('/costumes/{costume}', [CostumeController::class, 'show'])->name('costumes.show');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Booking routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/costumes/{costume}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::post('/bookings/{booking}/upload-payment', [BookingController::class, 'uploadPaymentSlip'])->name('bookings.upload-payment');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Admin routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/costumes', [CostumeController::class, 'index'])->name('admin.costumes.index');
        Route::get('/admin/costumes/create', [CostumeController::class, 'create'])->name('admin.costumes.create');
        Route::post('/admin/costumes', [CostumeController::class, 'store'])->name('admin.costumes.store');
        Route::get('/admin/costumes/{costume}/edit', [CostumeController::class, 'edit'])->name('admin.costumes.edit');
        Route::put('/admin/costumes/{costume}', [CostumeController::class, 'update'])->name('admin.costumes.update');
        Route::delete('/admin/costumes/{costume}', [CostumeController::class, 'destroy'])->name('admin.costumes.destroy');
        
        Route::post('/admin/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('admin.bookings.confirm');
        Route::post('/admin/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('admin.bookings.reject');
        Route::post('/admin/bookings/{booking}/complete', [BookingController::class, 'complete'])->name('admin.bookings.complete');
    });
});
