<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/about', [HomeController::class, 'about_index'])->name('about');

// Register
Route::get('/register', [AuthController::class, 'index']);
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'index_login']);
Route::post('/login', [AuthController::class, 'login']);

// Google
Route::get('/auth/google/redirect', [AuthController::class, 'google_redirect']);
Route::get('/auth/google/callback', [AuthController::class, 'google_callback']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Order
Route::get('/order', [MenuController::class, 'order'])->name('order');

// Payment
Route::post('/payment/notify', [PaymentController::class, 'notify'])->name('payment.notify');

// Reservation
// Route::get('/', [ReservationController::class, 'index'])->name('res.index');
// Route::post('/', [ReservationController::class, 'store'])->name('res.book');
// Route::get('/reservation', [ReservationController::class, 'myres_index'])->name('myres.index');
// Route::delete('/reservation/{res}', [ReservationController::class ,'cancel_res'])->name('res.cancel');
Route::get('/reservation', [ReservationController::class, 'myres_index'])->name('myres.index');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// PWA routes
Route::get('/manifest.json', function () {
    return response()->file(public_path('manifest.json'), [
        'Content-Type' => 'application/manifest+json',
        'Cache-Control' => 'public, max-age=86400',
    ]);
});

Route::get('/sw.js', function () {
    return response()->file(public_path('sw.js'), [
        'Content-Type'           => 'application/javascript',
        'Cache-Control'          => 'no-cache, no-store, must-revalidate',
        'Service-Worker-Allowed' => '/',
    ]);
});

Route::get('/offline', fn() => view('offline'))->name('offline');

// Authenticated User Routes
Route::middleware(['auth', 'user'])->group(function () {

    // Home / Reservation
    Route::post('/', [ReservationController::class, 'store'])->name('res.book');
    Route::delete('/reservation/{res}', [ReservationController::class, 'cancel_res'])->name('res.cancel');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
    Route::post('/cart/place-order', [CartController::class, 'placeOrder'])->name('cart.placeOrder');
    Route::patch('/cart/{cartItem}/quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove_from_cart'])->name('cart.remove');

    // Orders
    Route::get('/orders/track', [OrderController::class, 'track_index'])->name('order.track.latest');
    Route::get('/orders/track/{orderId}', [OrderController::class, 'track'])->name('order.track');
    Route::delete('/orders/{orderId}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::post('/orders/{orderId}/reorder', [CartController::class, 'reorder'])->name('order.reorder');

    // Payment
    Route::get('/payment/payfast/{orderId}', [PaymentController::class, 'redirectToPayfast'])->name('payment.payfast');
    Route::get('/payment/success/{orderId}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel/{orderId}', [PaymentController::class, 'cancel'])->name('payment.cancel');

    // Profile
    Route::get('/profile', [AuthController::class, 'user_profile_index'])->name('profile.index');
    Route::patch('/profile/edit', [AuthController::class, 'edit_profile'])->name('profile.edit');
    Route::patch('/profile/change-password', [AuthController::class, 'change_password'])->name('user.change.password');
    Route::delete('/profile/delete/{id}', [AuthController::class, 'delete_user'])->name('profile.delete');
});


// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');

    // Orders
    Route::get('/admin/orders', [AdminController::class, 'admin_orders_index'])->name('admin.orders.index');
    Route::patch('/admin/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.updateOrderStatus');

    // Menu management
    Route::resource('menu', MenuController::class)->except(['create', 'show', 'index'])->names('menu');

    // Reservations
    Route::get('/admin/reservations', [ReservationController::class, 'admin_res_index'])->name('admin.res.index');
    Route::patch('admin/reservations/{id}', [ReservationController::class, 'updateResStatus'])->name('res.updateResStatus');

    // Payments
    Route::get('/admin/payments', [AdminController::class, 'admin_payment_index'])->name('admin.payment.index');

    // Contacts
    Route::get('/admin/contacts', [ContactController::class, 'admin_form_index'])->name('admin.form.index');

    // Users
    Route::get('/admin/users', [AdminController::class, 'admin_user_index'])->name('admin.user.index');

    // Admin management
    Route::get('/admin/add', [AuthController::class, 'admin_add_index'])->name('admin.add.index');
    Route::post('/admin/add', [AuthController::class, 'admin_store'])->name('admin.store');
    Route::delete('/admin/delete/{id}', [AuthController::class, 'delete_user'])->name('admin.delete');

    // Gallery
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery', [GalleryController::class, 'add'])->name('gallery.add');
    Route::delete('/gallery/{image}', [GalleryController::class, 'delete'])->name('gallery.delete');

    // Profile
    Route::get('admin/profile', [AuthController::class, 'admin_profile_index'])->name('admin.profile.index');
    Route::patch('admin/profile/edit', [AuthController::class, 'edit_profile'])->name('admin.profile.edit');
    Route::patch('admin/profile/change-password', [AuthController::class, 'change_password'])->name('admin.change.password');
    Route::delete('admin/profile/delete/{id}', [AuthController::class, 'delete_user'])->name('admin.profile.delete');
});
