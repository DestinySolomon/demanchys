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

//Admin Dashboard Route
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


// Public events route
Route::get('/events', [EventController::class, 'index'])->name('events.index');
// public event details
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

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
          
      
    // Categories Management - KEEP ONLY THIS ONE
    Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    
     // SECURE MENU ITEMS ROUTES
    Route::get('/menu-items', [\App\Http\Controllers\Admin\MenuItemController::class, 'index'])->name('admin.menu-items.index');
    Route::get('/menu-items/create', [\App\Http\Controllers\Admin\MenuItemController::class, 'create'])->name('admin.menu-items.create');
    Route::post('/menu-items', [\App\Http\Controllers\Admin\MenuItemController::class, 'store'])->name('admin.menu-items.store');
    Route::get('/menu-items/{id}/edit', [\App\Http\Controllers\Admin\MenuItemController::class, 'edit'])->name('admin.menu-items.edit');
    Route::put('/menu-items/{id}', [\App\Http\Controllers\Admin\MenuItemController::class, 'update'])->name('admin.menu-items.update');
    Route::delete('/menu-items/{id}', [\App\Http\Controllers\Admin\MenuItemController::class, 'destroy'])->name('admin.menu-items.destroy');
       


    // ADD-ONS MANAGEMENT ROUTES
Route::get('/add-ons', [\App\Http\Controllers\Admin\AddOnController::class, 'index'])->name('admin.add-ons.index');
Route::get('/add-ons/create', [\App\Http\Controllers\Admin\AddOnController::class, 'create'])->name('admin.add-ons.create');
Route::post('/add-ons', [\App\Http\Controllers\Admin\AddOnController::class, 'store'])->name('admin.add-ons.store');
Route::get('/add-ons/{id}/edit', [\App\Http\Controllers\Admin\AddOnController::class, 'edit'])->name('admin.add-ons.edit');
Route::put('/add-ons/{id}', [\App\Http\Controllers\Admin\AddOnController::class, 'update'])->name('admin.add-ons.update');
Route::delete('/add-ons/{id}', [\App\Http\Controllers\Admin\AddOnController::class, 'destroy'])->name('admin.add-ons.destroy');

// API ROUTE FOR MENU ITEM ADD-ONS
Route::get('/add-ons/menu-item/{menuItemId}', [\App\Http\Controllers\Admin\AddOnController::class, 'getByMenuItem'])->name('admin.add-ons.by-menu-item');


// ORDERS MANAGEMENT ROUTES
Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/orders/delivery', [\App\Http\Controllers\Admin\OrderController::class, 'deliveryOrders'])->name('admin.orders.delivery');
Route::get('/orders/eat-in', [\App\Http\Controllers\Admin\OrderController::class, 'eatInOrders'])->name('admin.orders.eat-in');
Route::get('/orders/takeaway', [\App\Http\Controllers\Admin\OrderController::class, 'takeawayOrders'])->name('admin.orders.takeaway');
Route::get('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
Route::put('/orders/{id}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
Route::put('/orders/{id}/payment-status', [\App\Http\Controllers\Admin\OrderController::class, 'updatePaymentStatus'])->name('admin.orders.update-payment-status');
Route::delete('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('admin.orders.destroy');

// EVENTS MANAGEMENT ROUTES
Route::get('/events', [\App\Http\Controllers\Admin\EventController::class, 'index'])->name('admin.events.index');
Route::get('/events/upcoming', [\App\Http\Controllers\Admin\EventController::class, 'upcoming'])->name('admin.events.upcoming');
Route::get('/events/ongoing', [\App\Http\Controllers\Admin\EventController::class, 'ongoing'])->name('admin.events.ongoing');
Route::get('/events/past', [\App\Http\Controllers\Admin\EventController::class, 'past'])->name('admin.events.past');
Route::get('/events/create', [\App\Http\Controllers\Admin\EventController::class, 'create'])->name('admin.events.create');
Route::post('/events', [\App\Http\Controllers\Admin\EventController::class, 'store'])->name('admin.events.store');
Route::get('/events/{id}', [\App\Http\Controllers\Admin\EventController::class, 'show'])->name('admin.events.show');
Route::get('/events/{id}/edit', [\App\Http\Controllers\Admin\EventController::class, 'edit'])->name('admin.events.edit');
Route::put('/events/{id}', [\App\Http\Controllers\Admin\EventController::class, 'update'])->name('admin.events.update');
Route::put('/events/{id}/status', [\App\Http\Controllers\Admin\EventController::class, 'updateStatus'])->name('admin.events.update-status');
Route::delete('/events/{id}', [\App\Http\Controllers\Admin\EventController::class, 'destroy'])->name('admin.events.destroy');



// GALLERY MANAGEMENT ROUTES
Route::get('/gallery', [\App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('admin.gallery.index');
Route::get('/gallery/create', [\App\Http\Controllers\Admin\GalleryController::class, 'create'])->name('admin.gallery.create');
Route::post('/gallery', [\App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('admin.gallery.store');
Route::get('/gallery/{id}/edit', [\App\Http\Controllers\Admin\GalleryController::class, 'edit'])->name('admin.gallery.edit');
Route::put('/gallery/{id}', [\App\Http\Controllers\Admin\GalleryController::class, 'update'])->name('admin.gallery.update');
Route::delete('/gallery/{id}', [\App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('admin.gallery.destroy');



// USER MANAGEMENT ROUTES
Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
Route::get('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
   


// DELIVERY MAN ROUTES
Route::get('/delivery', [\App\Http\Controllers\Admin\DeliveryController::class, 'index'])->name('admin.delivery.index');
Route::get('/delivery/{id}', [\App\Http\Controllers\Admin\DeliveryController::class, 'show'])
    ->whereNumber('id')
    ->name('admin.delivery.show');

Route::get('/delivery/{id}/orders', [\App\Http\Controllers\Admin\DeliveryController::class, 'orders'])
    ->whereNumber('id')
    ->name('admin.delivery.orders');

Route::get('/delivery/{deliveryId}/order/{orderId}', [\App\Http\Controllers\Admin\DeliveryController::class, 'orderDetails'])
    ->whereNumber('deliveryId')
    ->whereNumber('orderId')
    ->name('admin.delivery.order-details');
Route::delete('/delivery/{id}', [\App\Http\Controllers\Admin\DeliveryController::class, 'destroy'])->whereNumber('id')->name('admin.delivery.destroy');

// Delivery Man Application Routes
Route::get('/delivery/pending', [\App\Http\Controllers\Admin\DeliveryController::class, 'pending'])->name('admin.delivery.pending');
Route::get('/delivery/rejected', [\App\Http\Controllers\Admin\DeliveryController::class, 'rejected'])->name('admin.delivery.rejected');
Route::post('/delivery/{id}/approve', [\App\Http\Controllers\Admin\DeliveryController::class, 'approve'])->whereNumber('id')->name('admin.delivery.approve');
Route::post('/delivery/{id}/reject', [\App\Http\Controllers\Admin\DeliveryController::class, 'reject'])->whereNumber('id')->name('admin.delivery.reject');

// BANNER MANAGEMENT ROUTES
// Promotional Banner Routes
Route::get('/banners/promotional', [\App\Http\Controllers\Admin\BannerController::class, 'promotional'])->name('admin.banners.promotional');
Route::get('/banners/promotional/create', [\App\Http\Controllers\Admin\BannerController::class, 'createPromotional'])->name('admin.banners.promotional.create');
Route::post('/banners/promotional', [\App\Http\Controllers\Admin\BannerController::class, 'storePromotional'])->name('admin.banners.promotional.store');

// Offer Deals Routes
Route::get('/banners/offers', [\App\Http\Controllers\Admin\BannerController::class, 'offers'])->name('admin.banners.offers');
Route::get('/banners/offers/create', [\App\Http\Controllers\Admin\BannerController::class, 'createOffer'])->name('admin.banners.offers.create');
Route::post('/banners/offers', [\App\Http\Controllers\Admin\BannerController::class, 'storeOffer'])->name('admin.banners.offers.store');

// Shared Routes (edit/update/delete/toggle) for both types
Route::get('/banners/{banner}/edit', [\App\Http\Controllers\Admin\BannerController::class, 'edit'])->name('admin.banners.edit');
Route::put('/banners/{banner}', [\App\Http\Controllers\Admin\BannerController::class, 'update'])->name('admin.banners.update');
Route::delete('/banners/{banner}', [\App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('admin.banners.destroy');
Route::post('/banners/{banner}/toggle', [\App\Http\Controllers\Admin\BannerController::class, 'toggle'])->name('admin.banners.toggle');


// CONTACT MESSAGES ROUTES
Route::get('/contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('admin.contacts.index');
Route::get('/contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('admin.contacts.show');
Route::delete('/contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('admin.contacts.destroy');
Route::post('/contacts/{contact}/mark-as-read', [\App\Http\Controllers\Admin\ContactController::class, 'markAsRead'])->name('admin.contacts.mark-as-read');
Route::post('/contacts/{contact}/mark-as-replied', [\App\Http\Controllers\Admin\ContactController::class, 'markAsReplied'])->name('admin.contacts.mark-as-replied');
Route::post('/contacts/{contact}/send-reply', [\App\Http\Controllers\Admin\ContactController::class, 'sendReply'])->name('admin.contacts.send-reply');



// TESTIMONIALS ROUTES
Route::get('/testimonials', [\App\Http\Controllers\Admin\TestimonialController::class, 'index'])->name('admin.testimonials.index');
Route::get('/testimonials/create', [\App\Http\Controllers\Admin\TestimonialController::class, 'create'])->name('admin.testimonials.create');
Route::post('/testimonials', [\App\Http\Controllers\Admin\TestimonialController::class, 'store'])->name('admin.testimonials.store');
Route::get('/testimonials/{testimonial}/edit', [\App\Http\Controllers\Admin\TestimonialController::class, 'edit'])->name('admin.testimonials.edit');
Route::put('/testimonials/{testimonial}', [\App\Http\Controllers\Admin\TestimonialController::class, 'update'])->name('admin.testimonials.update');
Route::delete('/testimonials/{testimonial}', [\App\Http\Controllers\Admin\TestimonialController::class, 'destroy'])->name('admin.testimonials.destroy');

// Additional routes
Route::post('/testimonials/{testimonial}/toggle-featured', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggleFeatured'])->name('admin.testimonials.toggle-featured');
Route::post('/testimonials/{testimonial}/toggle-approved', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggleApproved'])->name('admin.testimonials.toggle-approved');
Route::post('/testimonials/bulk-approve', [\App\Http\Controllers\Admin\TestimonialController::class, 'bulkApprove'])->name('admin.testimonials.bulk-approve');
Route::post('/testimonials/update-order', [\App\Http\Controllers\Admin\TestimonialController::class, 'updateOrder'])->name('admin.testimonials.update-order');



// BOOKINGS MANAGEMENT ROUTES
Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('admin.bookings.index');
Route::get('/bookings/today', [\App\Http\Controllers\Admin\BookingController::class, 'today'])->name('admin.bookings.today');
Route::get('/bookings/calendar', [\App\Http\Controllers\Admin\BookingController::class, 'calendar'])->name('admin.bookings.calendar');
Route::get('/bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('admin.bookings.show');
Route::post('/bookings/{booking}/update-status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('admin.bookings.update-status');
Route::post('/bookings/{booking}/update-notes', [\App\Http\Controllers\Admin\BookingController::class, 'updateNotes'])->name('admin.bookings.update-notes');
Route::delete('/bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('admin.bookings.destroy');
Route::post('/bookings/bulk-update', [\App\Http\Controllers\Admin\BookingController::class, 'bulkUpdate'])->name('admin.bookings.bulk-update');



// SETTINGS ROUTES
Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
Route::post('/settings/general', [\App\Http\Controllers\Admin\SettingController::class, 'updateGeneral'])->name('admin.settings.update-general');
Route::post('/settings/logo', [\App\Http\Controllers\Admin\SettingController::class, 'updateLogo'])->name('admin.settings.update-logo');
Route::post('/settings/recaptcha', [\App\Http\Controllers\Admin\SettingController::class, 'updateRecaptcha'])->name('admin.settings.update-recaptcha');
Route::post('/settings/whatsapp', [\App\Http\Controllers\Admin\SettingController::class, 'updateWhatsapp'])->name('admin.settings.update-whatsapp');
Route::post('/settings/analytics', [\App\Http\Controllers\Admin\SettingController::class, 'updateAnalytics'])->name('admin.settings.update-analytics');
Route::post('/settings/database', [\App\Http\Controllers\Admin\SettingController::class, 'clearDatabase'])->name('admin.settings.clear-database');
Route::post('/settings/dark-mode', [\App\Http\Controllers\Admin\SettingController::class, 'updateDarkMode'])->name('admin.settings.update-dark-mode');



// PAYMENT METHODS ROUTES
Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('admin.payments.index');
Route::get('/payments/create', [\App\Http\Controllers\Admin\PaymentController::class, 'create'])->name('admin.payments.create');
Route::post('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'store'])->name('admin.payments.store');
Route::get('/payments/{id}/edit', [\App\Http\Controllers\Admin\PaymentController::class, 'edit'])->name('admin.payments.edit');
Route::put('/payments/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'update'])->name('admin.payments.update');
Route::delete('/payments/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'destroy'])->name('admin.payments.destroy');
Route::get('/payments/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('admin.payments.show');
Route::post('/payments/toggle-status', [\App\Http\Controllers\Admin\PaymentController::class, 'toggleStatus'])->name('admin.payments.toggle-status');
Route::post('/payments/set-default', [\App\Http\Controllers\Admin\PaymentController::class, 'setDefault'])->name('admin.payments.set-default');




// NOTIFICATION ROUTES
Route::prefix('notifications')->name('admin.notifications.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('index');
    Route::get('/list', [\App\Http\Controllers\Admin\NotificationController::class, 'list'])->name('list');
    Route::get('/unread-count', [\App\Http\Controllers\Admin\NotificationController::class, 'unreadCount'])->name('unread-count');
    Route::post('/{id}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('mark-as-read');
    Route::post('/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    Route::delete('/{id}', [\App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('destroy');
    Route::delete('/', [\App\Http\Controllers\Admin\NotificationController::class, 'clearAll'])->name('clear-all');
});



});
});


// Google OAuth Routes
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback'])->name('google.callback');