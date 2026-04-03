<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard (SUDAH DIPERBAIKI)
    Route::get('/dashboard', function () {
        $totalCategories = Category::count();
        $totalMenus = Menu::count();
        $totalBestSeller = Menu::where('is_best_seller', true)->count();
        $totalActiveMenus = Menu::where('is_active', true)->count();

        $latestMenus = Menu::with('category')->latest()->take(5)->get();
        $categories = Category::latest()->take(6)->get();
        $bestSellers = Menu::where('is_best_seller', true)->latest()->take(4)->get();

        return view('dashboard', compact(
            'totalCategories',
            'totalMenus',
            'totalBestSeller',
            'totalActiveMenus',
            'latestMenus',
            'categories',
            'bestSellers'
        ));
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource Management (Categories & Menus)
    Route::resource('categories', CategoryController::class);
    Route::resource('menus', MenuController::class);
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze/Jetstream)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';