<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CashierController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController; // Import Controller Laporan
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $categories = Category::with(['menus' => function ($query) {
        $query->where('is_active', true);
    }])->get();

    $bestSellers = Menu::where('is_best_seller', true)
        ->where('is_active', true)
        ->latest()
        ->take(3)
        ->get();

    return view('welcome', compact('categories', 'bestSellers'));
});

Route::post('/reviews', [ReviewController::class, 'store'])->middleware('throttle:3,1')->name('reviews.store');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource Management (Menu & Kategori)
    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('menus', MenuController::class);
    });

    // Order History Management (Riwayat Pesanan Umum)
    Route::middleware('role:admin,kasir,owner')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

    // --- LAPORAN PENJUALAN & EXCEL ---
    Route::middleware('role:admin,owner')->prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');
    });

    // Reviews (Admin)
    Route::middleware('role:admin,owner')->group(function () {
        Route::get('/admin/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews.index');
        Route::delete('/admin/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    });

    // Cashier System
    Route::middleware('role:kasir')->prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/', [CashierController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CashierController::class, 'addToCart'])->name('add');
        Route::post('/increase/{id}', [CashierController::class, 'increaseQty'])->name('increase');
        Route::post('/decrease/{id}', [CashierController::class, 'decreaseQty'])->name('decrease');
        Route::delete('/remove/{id}', [CashierController::class, 'removeFromCart'])->name('remove');
        Route::delete('/clear', [CashierController::class, 'clearCart'])->name('clear');

        // Checkout & Order Routes
        Route::post('/checkout', [CashierController::class, 'checkout'])->name('checkout');
        Route::get('/order/{order}', [CashierController::class, 'showOrder'])->name('order.show');
    });
});

require __DIR__.'/auth.php';