<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeAuthController;
use App\Http\Controllers\Employee\ProductController;
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

Route::get('/', function () {
    return view('welcome');
});



// routes for customer functionalities

Route::get('/dashboard', function () {
    return view('customer.index');
})->name('dashboard')->middleware(['auth', 'verified']);

Route::get('/checkout', function () {
    return view('customer.checkout');
})->name('checkout');

Route::get('/order-success', function () {
    return view('customer.order-success');
})->name('order.success');

Route::get('/shop', function () {
    return view('customer.shop');
})->name('customer.shop');

Route::get('/orders', function () {
    return view('customer.diso');
})->name('customer.diso');

// Authentication routes (only for guests)
Route::prefix('employees')->name('employees.')->middleware('guest:employee')->group(function () {
    Route::get('/login', [EmployeeAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [EmployeeAuthController::class, 'login'])->name('login.submit');
});

// Employee dashboard route
Route::prefix('employees')->name('employees.')->middleware('auth:employee')->group(function () {
    Route::post('/logout', [EmployeeAuthController::class, 'logout'])->name('logout');

    // Route::get('/dashboard', function () {
    //     return view('employees.dashboard.index');
    // })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/products', function () {
        return view('employees.products.index');
    })->name('products.index');

    Route::resource('products', \App\Http\Controllers\Employee\ProductController::class);


    Route::get('/products/create', function () {
        return view('employees.products.create');
    })->name('products.create');


    Route::get('/orders', function () {
        return view('employees.orders.index');
    })->name('orders.index');

    // Low Stock Alerts
    Route::get('/low-stock', function () {
        return view('employees.lowstock.index');
    })->name('lowstock.index');

    Route::get('/profile', function () {
        return view('employees.profile.index');
    })->name('profile.index');
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
        // Route::get('/dashboard', function () {
        //     return view('admin.dashboard.index');
        // })->name('dashboard');
        Route::get('/dashboard', [AdminProductController::class, 'dashboard'])->name('dashboard');
        Route::get('/employees', [\App\Http\Controllers\Admin\EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
