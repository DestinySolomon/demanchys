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
