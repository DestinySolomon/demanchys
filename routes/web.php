<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ContactController;

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
Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('gallery');

// Admin Routes

Route::get('/admin/gallery', [GalleryAdminController::class, 'index'])->name('admin.gallery');
Route::post('/admin/gallery/upload', [GalleryAdminController::class, 'upload'])->name('admin.gallery.upload');
