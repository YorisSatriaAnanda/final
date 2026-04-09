@extends('layouts.admin')

@section('content')

    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detail Transaksi</h1>
                <p class="text-gray-500 mt-1">Informasi lengkap transaksi customer.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('orders.index') }}"
                   class="bg-gray-200 text-gray-800 px-5 py-3 rounded-2xl hover:bg-gray-300 transition">
                    Kembali
                </a>

                <button onclick="window.print()"
                        class="bg-red-700 text-white px-5 py-3 rounded-2xl hover:bg-red-800 transition shadow-md">
                    Print Struk
                </button>
            </div>
        </div>

        <div class="bg-white rounded-[30px] shadow-md overflow-hidden">
            <div class="p-8 border-b border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-bold text-red-700">Mekarjaya Coffee</h2>
                        <p class="text-gray-500 mt-2">Invoice Penjualan</p>
                    </div>

                    <div class="text-left md:text-right">
                        <p class="text-sm text-gray-500">Invoice</p>
                        <h3 class="text-xl font-bold text-gray-900">{{ $order->invoice_code }}</h3>
                        <p class="text-sm text-gray-500 mt-2">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-gray-100">
                <div>
                    <p class="text-sm text-gray-500 mb-2">Customer</p>
                    <h3 class="text-xl font-bold text-gray-900">
                        {{ $order->customer_name ?: 'Walk In Customer' }}
                    </h3>
                </div>

                <div class="md:text-right">
                    <p class="text-sm text-gray-500 mb-2">Pembayaran</p>
                    <h3 class="text-xl font-bold text-gray-900 uppercase">
                        {{ $order->payment_method }}
                    </h3>
                    <p class="mt-2">
                        @if($order->status === 'paid')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                Paid
                            </span>
                        @elseif($order->status === 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">
                                Pending
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                                Cancelled
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="p-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="py-4">Menu</th>
                                <th class="py-4">Qty</th>
                                <th class="py-4">Harga</th>
                                <th class="py-4 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr class="border-b last:border-0">
                                    <td class="py-4 font-semibold text-gray-900">{{ $item->menu->name }}</td>
                                    <td class="py-4">{{ $item->qty }}</td>
                                    <td class="py-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="py-4 text-right font-semibold">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-10 flex justify-end">
                    <div class="w-full max-w-md space-y-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Total</span>
                            <span class="font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between text-gray-600">
                            <span>Bayar</span>
                            <span class="font-semibold">Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between text-red-700 text-xl font-bold border-t pt-4">
                            <span>Kembalian</span>
                            <span>Rp {{ number_format($order->change_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection