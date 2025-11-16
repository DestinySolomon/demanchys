<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;



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

// Admin Routes
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::post('/admin/gallery/upload', [GalleryController::class, 'store'])->name('gallery.upload');
