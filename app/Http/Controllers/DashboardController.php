<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalMenus = Menu::count();
        $totalBestSeller = Menu::where('is_best_seller', true)->count();
        $totalActiveMenus = Menu::where('is_active', true)->count();

        $categories = Category::latest()->take(6)->get();

        $latestMenus = Menu::with('category')
            ->latest()
            ->take(5)
            ->get();

        $bestSellers = Menu::where('is_best_seller', true)
            ->latest()
            ->take(5)
            ->get();

        // 🔥 Tambahan data laporan dashboard
        $todayRevenue = Order::whereDate('created_at', today())
            ->where('status', 'paid')
            ->sum('total_price');

        $todayTransactions = Order::whereDate('created_at', today())
            ->where('status', 'paid')
            ->count();

        return view('dashboard', compact(
            'totalCategories',
            'totalMenus',
            'totalBestSeller',
            'totalActiveMenus',
            'categories',
            'latestMenus',
            'bestSellers',
            'todayRevenue',
            'todayTransactions'
        ));
    }
}