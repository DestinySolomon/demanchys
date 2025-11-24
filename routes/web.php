<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\OtpLoginController;


Route::get('/home', [HomeController::class, 'home'])->name('home');


// HOMEPAGE
Route::get('/', [HomeController::class, 'index'])->name('home');

// ABOUT
Route::get('/about', [AboutController::class, 'index'])->name('about');

// MENU
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// EVENTS
Route::get('/events', [EventsController::class, 'index'])->name('events');

// CONTACT
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Gallery

// Gallery Page (Frontend)
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
// Admin Routes


Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::post('/gallery/upload', [GalleryController::class, 'store'])->name('gallery.upload');




// FRONTEND EVENTS PAGE
Route::get('/events', [EventController::class, 'index'])->name('events');

// ADMIN EVENT MANAGEMENT
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/events', [EventController::class, 'adminIndex'])->name('admin.events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('admin.events.create');
    Route::post('/events/store', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
    Route::post('/events/{event}/update', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{event}/delete', [EventController::class, 'destroy'])->name('admin.events.delete');
});


// Table Booking Routes
Route::get('/book-table', [BookingController::class, 'create'])->name('book.table');
Route::post('/book-table', [BookingController::class, 'store'])->name('book.table.store');


// reservation route at footer
Route::get('/reservation', function () {
    return view('book-table');
})->name('reservation');



// Services Pages
Route::get('/private-events', [ServicesController::class, 'privateEvents'])->name('private-events');
Route::get('/catering', [ServicesController::class, 'catering'])->name('catering');
Route::get('/vip-packages', [ServicesController::class, 'vipPackages'])->name('vip-packages');
Route::get('/corporate-events', [ServicesController::class, 'corporateEvents'])->name('corporate-events');


// Menu Item Details
Route::get('/menu', [MenuController::class, 'index'])->name('menu');


// JSON endpoint used by the menu page JS to fetch one item + add-ons
Route::get('/menu/item/{id}', [MenuController::class, 'showItemJson'])->name('menu.item.json');


Route::middleware('auth')->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'index'])->name('checkout');
});

Route::post('/checkout/submit', [CheckoutController::class, 'submit'])->name('checkout.submit');


// WhatsApp OTP Login
Route::get('/login', [OtpLoginController::class, 'loginPage'])->name('login');
Route::post('/send-otp', [OtpLoginController::class, 'sendOtp']);
Route::get('/verify-otp', [OtpLoginController::class, 'verifyPage']);
Route::post('/verify-otp', [OtpLoginController::class, 'verifyOtp']);
