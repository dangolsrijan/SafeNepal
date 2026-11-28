<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SafetyCenterController;
use App\Http\Controllers\TravelerDashboardController;
use App\Http\Controllers\TripPlannerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SafeNepal Frontend Routes (Presentation & Demo Prototype Mode)
|--------------------------------------------------------------------------
| Backend management, database CRUD, and admin/agency panels are intentionally
| excluded from this frontend scope and reserved for future Filament integration.
*/

// Public Website
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// Discovery & Exploration
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->name('packages.show');

Route::get('/guides', [GuideController::class, 'index'])->name('guides.index');
Route::get('/guides/{slug}', [GuideController::class, 'show'])->name('guides.show');

Route::get('/agencies', [AgencyController::class, 'index'])->name('agencies.index');
Route::get('/agencies/{slug}', [AgencyController::class, 'show'])->name('agencies.show');

// Smart Trip Planner (Frontend Demo)
Route::get('/trip-planner', [TripPlannerController::class, 'index'])->name('planner.index');
Route::post('/trip-planner/generate', [TripPlannerController::class, 'generate'])->name('planner.generate');

// Safety Center & Help Near Me (Frontend Demo)
Route::get('/safety', [SafetyCenterController::class, 'index'])->name('safety.index');
Route::get('/safety/help-near-me', [SafetyCenterController::class, 'helpNearMe'])->name('safety.help-near-me');

// Frontend Auth Pages (Visual Prototype — Demo Responses)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Demo Booking Workflow (No Real Reservation or Payment)
Route::get('/packages/{slug}/book', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/packages/{slug}/book', [BookingController::class, 'review'])->name('bookings.review');
Route::get('/bookings/{code}/payment', [BookingController::class, 'showPayment'])->name('bookings.payment');
Route::post('/bookings/{code}/payment', [BookingController::class, 'completeDemo'])->name('bookings.payment.process');

// Traveler Dashboard (Frontend-Only Demo State)
Route::prefix('traveler')->name('traveler.')->group(function (): void {
    Route::get('/dashboard', [TravelerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/trips', [TravelerDashboardController::class, 'trips'])->name('trips.index');
    Route::get('/trips/{slug}', [TravelerDashboardController::class, 'showTrip'])->name('trips.show');
    Route::get('/bookings', [TravelerDashboardController::class, 'bookings'])->name('bookings.index');
    Route::get('/saved', [TravelerDashboardController::class, 'savedItems'])->name('saved.index');
    Route::get('/inquiries', [TravelerDashboardController::class, 'inquiries'])->name('inquiries.index');
    Route::get('/safety', [TravelerDashboardController::class, 'safety'])->name('safety.index');
    Route::get('/reviews', [TravelerDashboardController::class, 'reviews'])->name('reviews.index');
    Route::get('/profile', [TravelerDashboardController::class, 'profile'])->name('profile.index');
});
