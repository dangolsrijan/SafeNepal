<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AgencyDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SafetyCenterController;
use App\Http\Controllers\TravelerDashboardController;
use App\Http\Controllers\TripPlannerController;
use Illuminate\Support\Facades\Route;

// Public Website
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// Discovery & Exploration
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');

Route::get('/guides', [GuideController::class, 'index'])->name('guides.index');
Route::get('/guides/{guide}', [GuideController::class, 'show'])->name('guides.show');

Route::get('/agencies', [AgencyController::class, 'index'])->name('agencies.index');
Route::get('/agencies/{agency}', [AgencyController::class, 'show'])->name('agencies.show');

// Smart Trip Planner
Route::get('/trip-planner', [TripPlannerController::class, 'index'])->name('planner.index');
Route::post('/trip-planner/generate', [TripPlannerController::class, 'generate'])->name('planner.generate');
Route::post('/trip-planner/save', [TripPlannerController::class, 'save'])->middleware('auth')->name('planner.save');

// Safety Center & Help Near Me
Route::get('/safety', [SafetyCenterController::class, 'index'])->name('safety.index');
Route::get('/safety/help-near-me', [SafetyCenterController::class, 'helpNearMe'])->name('safety.help-near-me');

// Authentication
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated Shared Actions (Saved Items, Reviews, Inquiries, Profile)
Route::middleware('auth')->group(function (): void {
    Route::post('/saved-items/toggle', [EngagementController::class, 'toggleSavedItem'])->name('saved-items.toggle');
    Route::post('/reviews', [EngagementController::class, 'storeReview'])->name('reviews.store');
    Route::post('/inquiries', [EngagementController::class, 'storeInquiry'])->name('inquiries.store');
    Route::post('/inquiries/{inquiry}/reply', [EngagementController::class, 'replyInquiry'])->name('inquiries.reply');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});

// Traveler Booking & Demo Payment Workflow
Route::middleware(['auth', 'role:traveler'])->group(function (): void {
    Route::get('/packages/{package}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/packages/{package}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/payment', [BookingController::class, 'showPayment'])->name('bookings.payment');
    Route::post('/bookings/{booking}/payment', [BookingController::class, 'processDemoPayment'])->name('bookings.payment.process');
});

// Traveler Dashboard
Route::prefix('traveler')->name('traveler.')->middleware(['auth', 'role:traveler'])->group(function (): void {
    Route::get('/dashboard', [TravelerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/trips', [TravelerDashboardController::class, 'trips'])->name('trips.index');
    Route::get('/trips/{trip}', [TravelerDashboardController::class, 'showTrip'])->name('trips.show');
    Route::put('/trips/{trip}', [TravelerDashboardController::class, 'updateTrip'])->name('trips.update');
    Route::post('/trips/{trip}/regenerate', [TravelerDashboardController::class, 'regenerateTrip'])->name('trips.regenerate');
    Route::post('/trips/{trip}/days/{day}/activities', [TravelerDashboardController::class, 'addActivity'])->name('trips.activities.store');
    Route::put('/trips/{trip}/activities/{activity}', [TravelerDashboardController::class, 'updateActivity'])->name('trips.activities.update');
    Route::delete('/trips/{trip}/activities/{activity}', [TravelerDashboardController::class, 'removeActivity'])->name('trips.activities.destroy');

    Route::get('/bookings', [TravelerDashboardController::class, 'bookings'])->name('bookings.index');
    Route::get('/saved', [TravelerDashboardController::class, 'savedItems'])->name('saved.index');
    Route::get('/inquiries', [TravelerDashboardController::class, 'inquiries'])->name('inquiries.index');
    Route::get('/reviews', [TravelerDashboardController::class, 'reviews'])->name('reviews.index');

    Route::get('/safety', [TravelerDashboardController::class, 'safety'])->name('safety.index');
    Route::post('/safety/sos', [TravelerDashboardController::class, 'triggerSos'])->name('safety.sos');
    Route::post('/safety/check-in/start', [TravelerDashboardController::class, 'startCheckIn'])->name('safety.checkin.start');
    Route::post('/safety/check-in/{session}/confirm', [TravelerDashboardController::class, 'confirmCheckIn'])->name('safety.checkin.confirm');
    Route::post('/safety/check-in/{session}/end', [TravelerDashboardController::class, 'endCheckIn'])->name('safety.checkin.end');
    Route::post('/safety/contacts', [TravelerDashboardController::class, 'storePersonalContact'])->name('safety.contacts.store');
});

// Agency Dashboard
Route::prefix('agency')->name('agency.')->middleware(['auth', 'role:agency'])->group(function (): void {
    Route::get('/dashboard', [AgencyDashboardController::class, 'index'])->name('dashboard');
    Route::get('/packages', [AgencyDashboardController::class, 'packages'])->name('packages.index');
    Route::get('/packages/create', [AgencyDashboardController::class, 'createPackage'])->name('packages.create');
    Route::post('/packages', [AgencyDashboardController::class, 'storePackage'])->name('packages.store');
    Route::get('/packages/{package}/edit', [AgencyDashboardController::class, 'editPackage'])->name('packages.edit');
    Route::put('/packages/{package}', [AgencyDashboardController::class, 'updatePackage'])->name('packages.update');
    Route::delete('/packages/{package}', [AgencyDashboardController::class, 'destroyPackage'])->name('packages.destroy');
    Route::patch('/packages/{package}/toggle-publish', [AgencyDashboardController::class, 'togglePublishPackage'])->name('packages.toggle-publish');

    Route::get('/bookings', [AgencyDashboardController::class, 'bookings'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [AgencyDashboardController::class, 'updateBookingStatus'])->name('bookings.status');

    Route::get('/inquiries', [AgencyDashboardController::class, 'inquiries'])->name('inquiries.index');
    Route::get('/profile', [AgencyDashboardController::class, 'profile'])->name('profile.edit');
    Route::put('/profile', [AgencyDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/reviews', [AgencyDashboardController::class, 'reviews'])->name('reviews.index');
});

// Admin Dashboard
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function (): void {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.index');
    Route::patch('/users/{user}/toggle-active', [AdminDashboardController::class, 'toggleUserActive'])->name('users.toggle-active');

    Route::get('/agencies', [AdminDashboardController::class, 'agencies'])->name('agencies.index');
    Route::patch('/agencies/{agency}/status', [AdminDashboardController::class, 'updateAgencyStatus'])->name('agencies.status');

    Route::get('/guides', [AdminDashboardController::class, 'guides'])->name('guides.index');
    Route::patch('/guides/{guide}/status', [AdminDashboardController::class, 'updateGuideStatus'])->name('guides.status');

    Route::get('/destinations', [AdminDashboardController::class, 'destinations'])->name('destinations.index');
    Route::post('/destinations', [AdminDashboardController::class, 'storeDestination'])->name('destinations.store');
    Route::delete('/destinations/{destination}', [AdminDashboardController::class, 'destroyDestination'])->name('destinations.destroy');

    Route::get('/packages', [AdminDashboardController::class, 'packages'])->name('packages.index');
    Route::patch('/packages/{package}/approval', [AdminDashboardController::class, 'updatePackageApproval'])->name('packages.approval');
    Route::delete('/packages/{package}', [AdminDashboardController::class, 'destroyPackage'])->name('packages.destroy');

    Route::get('/bookings', [AdminDashboardController::class, 'bookings'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [AdminDashboardController::class, 'updateBookingStatus'])->name('bookings.status');

    Route::get('/reviews', [AdminDashboardController::class, 'reviews'])->name('reviews.index');
    Route::delete('/reviews/{review}', [AdminDashboardController::class, 'destroyReview'])->name('reviews.destroy');

    Route::get('/safety', [AdminDashboardController::class, 'safety'])->name('safety.index');
    Route::put('/safety/information/{safetyInformation}', [AdminDashboardController::class, 'updateSafetyInformation'])->name('safety.info.update');
    Route::post('/safety/alerts', [AdminDashboardController::class, 'storeSafetyAlert'])->name('safety.alerts.store');
    Route::patch('/safety/alerts/{alert}/toggle', [AdminDashboardController::class, 'toggleSafetyAlert'])->name('safety.alerts.toggle');
    Route::post('/safety/contacts', [AdminDashboardController::class, 'storeEmergencyContact'])->name('safety.contacts.store');
});
