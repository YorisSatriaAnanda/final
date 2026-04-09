<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter ?? 'today';
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $ordersQuery = Order::where('status', 'paid');

        // =========================
        // FILTER TANGGAL (Reusable)
        // =========================
        $this->applyFilter($ordersQuery, $filter, $startDate, $endDate);

        // Clone query untuk kebutuhan data yang berbeda-beda
        $summaryOrders = clone $ordersQuery;
        $latestOrdersQuery = clone $ordersQuery;
        $chartOrders = clone $ordersQuery;

        // =========================
        // SUMMARY
        // =========================
        $totalTransactions = $summaryOrders->count();
        $totalRevenue = (clone $ordersQuery)->sum('total_price');
        $averageTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // Hitung Total Item Terjual menggunakan whereHas agar sinkron dengan filter Order
        $totalItemsSold = OrderItem::whereHas('order', function ($q) use ($filter, $startDate, $endDate) {
            $q->where('status', 'paid');
            $this->applyFilter($q, $filter, $startDate, $endDate);
        })->sum('qty');

        // =========================
        // CHART HARIAN
        // =========================
        $chartRaw = $chartOrders
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as revenue, COUNT(*) as transactions')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Hitung Item Terjual Harian secara terpisah
        $chartItemsRaw = OrderItem::whereHas('order', function ($q) use ($filter, $startDate, $endDate) {
            $q->where('status', 'paid');
            $this->applyFilter($q, $filter, $startDate, $endDate);
        })
        ->selectRaw('DATE(created_at) as date, SUM(qty) as total_qty')
        ->groupBy('date')
        ->pluck('total_qty', 'date');

        $chartLabels = $chartRaw->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M'))->values();
        $chartRevenue = $chartRaw->pluck('revenue')->map(fn($v) => (int) $v)->values();
        $chartTransactions = $chartRaw->pluck('transactions')->map(fn($v) => (int) $v)->values();
        $chartItemsSold = $chartRaw->pluck('date')->map(fn($date) => (int) ($chartItemsRaw[$date] ?? 0))->values();

        // =========================
        // TOP MENU & TOP CATEGORY
        // =========================
        $topMenus = OrderItem::with('menu')
            ->select('menu_id')
            ->selectRaw('SUM(qty) as total_qty, SUM(subtotal) as total_sales')
            ->whereHas('order', function ($q) use ($filter, $startDate, $endDate) {
                $q->where('status', 'paid');
                $this->applyFilter($q, $filter, $startDate, $endDate);
            })
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $topCategories = Category::select('categories.id', 'categories.name')
            ->join('menus', 'menus.category_id', '=', 'categories.id')
            ->join('order_items', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'paid')
            ->groupBy('categories.id', 'categories.name')
            ->selectRaw('SUM(order_items.qty) as total_qty, SUM(order_items.subtotal) as total_sales')
            ->orderByDesc('total_qty')
            ->limit(5);
        
        $this->applyFilter($topCategories, $filter, $startDate, $endDate, 'orders.created_at');
        $topCategories = $topCategories->get();

        // =========================
        // LATEST ORDERS
        // =========================
        $latestOrders = $latestOrdersQuery->latest()->take(10)->get();

        return view('reports.index', compact(
            'filter', 'startDate', 'endDate', 'totalTransactions', 'totalRevenue',
            'totalItemsSold', 'averageTransaction', 'chartLabels', 'chartRevenue',
            'chartTransactions', 'chartItemsSold', 'topMenus', 'topCategories', 'latestOrders'
        ));
    }

    public function exportExcel(Request $request)
    {
        $filter = $request->filter ?? 'today';
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $ordersQuery = Order::with('items.menu')->where('status', 'paid');
        $this->applyFilter($ordersQuery, $filter, $startDate, $endDate);

        $orders = $ordersQuery->latest()->get();
        $filename = 'laporan-penjualan-' . now()->format('Y-m-d-His') . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(new OrdersExport($orders), $filename);
    }

    /**
     * Helper untuk menerapkan filter tanggal agar tidak nulis berulang-ulang
     */
    private function applyFilter($query, $filter, $startDate, $endDate, $column = 'created_at')
    {
        if ($filter === 'today') {
            $query->whereDate($column, Carbon::today());
        } elseif ($filter === 'week') {
            $query->whereBetween($column, [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter === 'month') {
            $query->whereMonth($column, Carbon::now()->month)->whereYear($column, Carbon::now()->year);
        } elseif ($filter === 'custom' && $startDate && $endDate) {
            $query->whereBetween($column, [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        }
    }
}