<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $date = $request->date;

        $orders = Order::withCount('items')
            ->when($search, function ($query) use ($search) {
                $query->where('invoice_code', 'like', '%' . $search . '%')
                      ->orWhere('customer_name', 'like', '%' . $search . '%');
            })
            ->when($date, function ($query) use ($date) {
                $query->whereDate('created_at', $date);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())->sum('total_price');
        $allRevenue = Order::sum('total_price');

        return view('orders.index', compact(
            'orders',
            'todayOrders',
            'todayRevenue',
            'allRevenue',
            'search',
            'date'
        ));
    }

    public function show(Order $order)
    {
        $order->load('items.menu');

        return view('orders.show', compact('order'));
    }
}