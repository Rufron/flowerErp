<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\EmployeeAuthController;
use App\Http\Controllers\Employee\ProductController;
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Models\Admin;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Customer\StripeController;
use App\Http\Controllers\Customer\StripeWebhookController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\MpesaController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/test-csrf', function() {
    return response()->json(['message' => 'CSRF bypass working!']);
});



Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

 // Google login
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');




// routes for customer functionalities

// Customer routes (default users)
Route::middleware(['auth', 'verified'])->name('customer.')->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('customer.index');
    // })->name('dashboard');


    Route::get('/dashboard', [CustomerProductController::class, 'index'])->name('dashboard');

    // product detail route
    Route::get('/product/{id}', [CustomerProductController::class, 'show'])->name('product.detail');

    // individual checkout route.
    Route::get('/checkout/direct/{productId}', [CheckoutController::class, 'directCheckout'])->name('checkout.direct');

    // to add many other cart in checkout
    Route::post('/cart/add', [CheckoutController::class, 'addToCart'])->name('cart.add');
    
    Route::get('/checkout', function () {
        return view('customer.checkout');
    })->name('checkout');

    Route::get('/order-success', function () {
        return view('customer.order-success');
    })->name('order.success');

    Route::get('/shop', function () {
        return view('customer.shop');
    })->name('shop');

    // Checkout pages / API
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place');

    // Order success page
    Route::get('/order-success', [CheckoutController::class, 'success'])->name('order.success');

    // Route::get('/orders', function () {
    //     return view('customer.diso'); // rename file later if needed
    // })->name('orders');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');

    // stripe payments
    // Route::get('/stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::post('/stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/payment/success', [StripeController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [StripeController::class, 'cancel'])->name('payment.cancel');
    // Webhook
    Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
});



// Employee routes
Route::prefix('employees')->name('employees.')->group(function () {

    // Guest routes (only for employees who are not logged in)
    Route::middleware('guest:employees')->group(function () {
        Route::get('/login', [EmployeeAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [EmployeeAuthController::class, 'login'])->name('login.submit');
    });

    // Protected routes (only for logged-in employees)
    Route::middleware('auth:employees')->group(function () {
        Route::post('/logout', [EmployeeAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route::resource('dashboard', DashboardController::class);

        Route::get('/products', function () {
            return view('employees.products.index');
        })->name('products.index');

        Route::resource('products', \App\Http\Controllers\Employee\ProductController::class);

        Route::get('/products/create', function () {
            return view('employees.products.create');
        })->name('products.create');

        Route::get('/orders', [App\Http\Controllers\Employee\OrderController::class, 'index'])
         ->name('orders.index');

        // Low Stock Alerts
        Route::get('/low-stock', function () {
            return view('employees.lowstock.index');
        })->name('lowstock.index');

        Route::get('/profile', function () {
            return view('employees.profile.index');
        })->name('profile.index');
    });
});





// Admin dashboard route

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes (only for admins who are not logged in)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    // Protected routes (only for logged-in admins)
    Route::middleware('auth:admin')->group(function () {

        Route::get('/dashboard', [AdminProductController::class, 'dashboard'])->name('dashboard');
        Route::patch('/orders/{order}/{status}', [AdminOrderController::class, 'update'])
        ->name('orders.update');
        Route::get('/employees', [\App\Http\Controllers\Admin\EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // mpesa routes
    Route::post('/mpesa/stk-push', [MpesaController::class, 'stkPush'])->name('customer.mpesa.stk-push');
    Route::get('/mpesa/pending', [MpesaController::class, 'pending'])->name('customer.mpesa.pending');
    Route::get('/mpesa/status', [MpesaController::class, 'status'])->name('customer.mpesa.status');
});

// Public callback route (no auth)
Route::post('/mpesa/callback', [MpesaController::class, 'callback'])->name('customer.mpesa.callback');


require __DIR__ . '/auth.php';
