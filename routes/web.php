<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;

// Admin Panel Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\AlbumController as AdminAlbumController;
use App\Http\Controllers\Admin\CustomerController;

// Models for Dashboard Counts
use App\Models\Category;
use App\Models\Album;
use App\Models\Booking;
use App\Models\User;


// Home Page Route
Route::get('/', function () {
    return view('home');
})->name('home');

// Album Routes (Frontend)
Route::get('/albums', [AlbumController::class, 'index'])->name('album');
Route::get('/albums/{album:slug}', [AlbumController::class, 'show'])->name('album.show');
Route::get('/album/{categorySlug}', [AlbumController::class, 'show'])->name('album.show.category');

// Contact Page Routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// About Page Route
Route::get('/aboutpage', [AboutController::class, 'index'])->name('aboutpage');

// Booking Routes (Frontend) - Restricted to authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/book', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/book/{categorySlug}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
});

// Authentication Routes (Login, Register, Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Routes for logged-in users only (General Dashboard if any)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin Routes Group
// All routes within this group will have 'admin/' prefix in URL
// and 'admin.' prefix in route names.
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard Route
    Route::get('/dashboard', function () {
        $totalCategories = Category::count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalAlbums = Album::count();
        $totalCustomers = User::where('is_admin', 0)->count();

        return view('admin.dashboard', compact('totalCategories', 'totalBookings', 'pendingBookings', 'totalAlbums', 'totalCustomers'));
    })->name('dashboard');

    // Category Management Resource Routes
    Route::resource('categories', AdminCategoryController::class);

    // Booking Images Specific Routes (Define before resource route)
    Route::get('bookings/upload', [AdminBookingController::class, 'showUploadForm'])->name('bookings.upload-form');
    Route::post('bookings/upload', [AdminBookingController::class, 'processUpload'])->name('bookings.process-upload');
    Route::post('bookings/{booking}/upload-images', [AdminBookingController::class, 'uploadImages'])->name('bookings.upload-images');
    Route::delete('booking-images/{image}', [AdminBookingController::class, 'destroyImage'])->name('booking-images.destroy');

    // Booking Management Resource Routes (Admin Panel)
    Route::resource('bookings', AdminBookingController::class)->except(['create', 'store']);

    // Album Management Routes (Admin Panel)
    // Album Photos Upload and Deletion routes should be defined BEFORE the resource route
    Route::post('albums/{album}/upload-photos', [AdminAlbumController::class, 'uploadPhotos'])->name('albums.upload-photos');
    Route::delete('photos/{photo}', [AdminAlbumController::class, 'destroyPhoto'])->name('photos.destroy');

    // Album Management Resource Routes
    Route::resource('albums', AdminAlbumController::class);

    // Customer Routes
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
});