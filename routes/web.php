<?php

use App\Http\Controllers\ProfileController;
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
use Illuminate\Support\Facades\Route;

// Include Breeze authentication routes FIRST
require __DIR__.'/auth.php';

//Admind Dashboard Route
Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->middleware(['auth'])->name('dashboard');
// User Dashboard
Route::get('/my-account', function () {
    return view('user-dashboard');
})->middleware(['auth'])->name('user.dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

// HOMEPAGE - Only one route for home
Route::get('/', [HomeController::class, 'home'])->name('home');

// PUBLIC ROUTES
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/events', [EventsController::class, 'index'])->name('events');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::post('/gallery/upload', [GalleryController::class, 'store'])->name('gallery.upload');
Route::get('/book-table', [BookingController::class, 'create'])->name('book.table');
Route::post('/book-table', [BookingController::class, 'store'])->name('book.table.store');
Route::get('/reservation', function () {
    return view('book-table');
})->name('reservation');

// Services Pages
Route::get('/private-events', [ServicesController::class, 'privateEvents'])->name('private-events');
Route::get('/catering', [ServicesController::class, 'catering'])->name('catering');
Route::get('/vip-packages', [ServicesController::class, 'vipPackages'])->name('vip-packages');
Route::get('/corporate-events', [ServicesController::class, 'corporateEvents'])->name('corporate-events');

// Menu JSON API
Route::get('/menu/item/{id}', [MenuController::class, 'showItemJson'])->name('menu.item.json');

// AUTHENTICATED ROUTES
Route::middleware('auth')->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    
    // ADMIN ROUTES
    Route::prefix('admin')->group(function () {
        Route::get('/events', [EventController::class, 'adminIndex'])->name('admin.events.index');
        Route::get('/events/create', [EventController::class, 'create'])->name('admin.events.create');
        Route::post('/events/store', [EventController::class, 'store'])->name('admin.events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
        Route::post('/events/{event}/update', [EventController::class, 'update'])->name('admin.events.update');
        Route::delete('/events/{event}/delete', [EventController::class, 'destroy'])->name('admin.events.delete');
    });
});

Route::post('/checkout/submit', [CheckoutController::class, 'submit'])->name('checkout.submit');



// TEMPORARY ROUTE - CHECK MENU DATA (REMOVE AFTER)
Route::get('/check-menu-data', function () {
    $categoryCount = \App\Models\MenuCategory::count();
    $itemCount = \App\Models\MenuItem::count();
    $addOnCount = \App\Models\AddOn::count();
    
    return [
        'categories' => $categoryCount,
        'menu_items' => $itemCount,
        'add_ons' => $addOnCount
    ];
});