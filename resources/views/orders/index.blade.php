@extends('layouts.admin')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Riwayat Transaksi</h1>
        <p class="text-gray-500 mt-1">Lihat semua histori transaksi penjualan coffee shop kamu.</p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-[28px] p-6 shadow-md">
            <p class="text-gray-500 mb-2">Transaksi Hari Ini</p>
            <h2 class="text-4xl font-bold text-red-700">{{ $todayOrders }}</h2>
        </div>

        @if($isAdminOrOwner)
        <div class="bg-white rounded-[28px] p-6 shadow-md">
            <p class="text-gray-500 mb-2">Omset Hari Ini</p>
            <h2 class="text-3xl font-bold text-red-700">
                Rp {{ number_format($todayRevenue, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white rounded-[28px] p-6 shadow-md">
            <p class="text-gray-500 mb-2">Total Omset</p>
            <h2 class="text-3xl font-bold text-red-700">
                Rp {{ number_format($allRevenue, 0, ',', '.') }}
            </h2>
        </div>
        @endif
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-[30px] p-6 shadow-md mb-8">
        <form method="GET" action="{{ route('orders.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Invoice / Customer</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Contoh: INV-2026 / Budi"
                       class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Tanggal</label>
                <input type="date"
                       name="date"
                       value="{{ request('date') }}"
                       class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
            </div>

            <div class="md:col-span-3 flex gap-3">
                <button class="bg-red-700 text-white px-6 py-3 rounded-2xl hover:bg-red-800 transition shadow-md">
                    Filter
                </button>

                <a href="{{ route('orders.index') }}"
                   class="bg-gray-200 text-gray-800 px-6 py-3 rounded-2xl hover:bg-gray-300 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-[30px] shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Daftar Transaksi</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#fafafa]">
                    <tr class="text-left text-gray-500">
                        <th class="px-6 py-4">Invoice</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Item</th>
                        <th class="px-6 py-4">Pembayaran</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-t hover:bg-red-50/30 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $order->invoice_code }}</h4>
                                    <p class="text-sm text-gray-500">#{{ $order->id }}</p>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $order->customer_name ?: 'Walk In Customer' }}
                                @if($order->notes)
                                    <div class="text-xs text-gray-500 mt-1 italic break-words max-w-[200px]">Catatan: {{ $order->notes }}</div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('H:i') }}</p>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $order->items_count }} item
                            </td>

                            <td class="px-6 py-4 uppercase">
                                {{ $order->payment_method }}
                            </td>

                            <td class="px-6 py-4">
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
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                @if($order->discount > 0)
                                    <div class="text-xs text-red-500 mt-1">Diskon: Rp {{ number_format($order->discount, 0, ',', '.') }}</div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <a href="{{ route('orders.show', $order) }}"
                                   class="bg-red-700 text-white px-4 py-2 rounded-xl hover:bg-red-800 transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

@endsection