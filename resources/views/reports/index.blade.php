@extends('layouts.admin')

@section('content')

<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Laporan Penjualan</h1>
        <p class="text-gray-500 mt-1">Pantau performa penjualan coffee shop kamu.</p>
    </div>

    <a href="{{ route('reports.export.excel', request()->query()) }}"
       class="bg-green-600 text-white px-6 py-3 rounded-2xl hover:bg-green-700 transition shadow-md inline-flex items-center justify-center gap-2">
        <i data-lucide="download" class="w-5 h-5"></i>
        Export Excel
    </a>
</div>

{{-- FILTER --}}
<div class="bg-white rounded-[30px] p-6 shadow-md mb-8">
    <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Periode</label>
            <select name="filter" id="filterSelect"
                    class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
                <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="custom" {{ $filter == 'custom' ? 'selected' : '' }}>Custom Tanggal</option>
            </select>
        </div>

        <div id="startDateWrap" class="{{ $filter == 'custom' ? '' : 'hidden' }}">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ $startDate }}"
                   class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
        </div>

        <div id="endDateWrap" class="{{ $filter == 'custom' ? '' : 'hidden' }}">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
            <input type="date" name="end_date" value="{{ $endDate }}"
                   class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
        </div>

        <div class="flex items-end gap-3">
            <button class="bg-red-700 text-white px-6 py-4 rounded-2xl hover:bg-red-800 transition shadow-md flex-1 md:flex-none">
                Terapkan
            </button>

            <a href="{{ route('reports.index') }}"
               class="bg-gray-200 text-gray-800 px-6 py-4 rounded-2xl hover:bg-gray-300 transition flex-1 md:flex-none text-center">
                Reset
            </a>
        </div>
    </form>
</div>

{{-- RINGKASAN --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-[28px] p-6 shadow-md">
        <p class="text-gray-500 mb-2">Total Transaksi</p>
        <h2 class="text-4xl font-bold text-red-700">{{ $totalTransactions }}</h2>
    </div>

    <div class="bg-white rounded-[28px] p-6 shadow-md">
        <p class="text-gray-500 mb-2">Total Omset</p>
        <h2 class="text-3xl font-bold text-red-700">
            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </h2>
    </div>

    <div class="bg-white rounded-[28px] p-6 shadow-md">
        <p class="text-gray-500 mb-2">Item Terjual</p>
        <h2 class="text-4xl font-bold text-red-700">{{ $totalItemsSold }}</h2>
    </div>

    <div class="bg-white rounded-[28px] p-6 shadow-md">
        <p class="text-gray-500 mb-2">Rata-rata Transaksi</p>
        <h2 class="text-3xl font-bold text-red-700">
            Rp {{ number_format($averageTransaction, 0, ',', '.') }}
        </h2>
    </div>
</div>

{{-- MAIN CHART --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
    <div class="xl:col-span-2 bg-white rounded-[30px] p-6 shadow-md">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Grafik Penjualan Advanced</h2>

            <div class="flex gap-2 flex-wrap">
                <button type="button" onclick="switchMainChart('revenue')" class="chart-btn bg-red-700 text-white px-4 py-2 rounded-xl text-sm" id="btnRevenue">Omset</button>
                <button type="button" onclick="switchMainChart('transactions')" class="chart-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm" id="btnTransactions">Transaksi</button>
                <button type="button" onclick="switchMainChart('items')" class="chart-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm" id="btnItems">Item Terjual</button>
            </div>
        </div>

        <div class="h-[380px]">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- TOP MENU --}}
    <div class="bg-white rounded-[30px] p-6 shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Menu Terlaris</h2>
            <i data-lucide="star" class="w-6 h-6 text-yellow-500 fill-current"></i>
        </div>

        <div class="space-y-4">
            @if (count($topMenus ?? []) > 0)
                @foreach ($topMenus as $item)
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#fafafa] hover:shadow transition">
                        @if ($item->menu && $item->menu->image)
                            <img src="{{ asset('storage/' . $item->menu->image) }}"
                                 class="w-16 h-16 rounded-2xl object-cover"
                                 alt="{{ $item->menu->name }}">
                        @else
                            <div class="w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center text-red-700">
                                <i data-lucide="coffee" class="w-8 h-8"></i>
                            </div>
                        @endif
    
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 leading-tight mb-1">{{ $item->menu?->name ?? 'Menu Dihapus' }}</h3>
                            <p class="text-lg font-semibold text-gray-900 leading-none">Terjual {{ $item->total_qty }}x</p>
                        </div>
    
                        <div class="text-right flex flex-col justify-end">
                            <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-400 mb-1">Total Nilai</p>
                            <p class="text-sm font-medium text-gray-400">
                                Rp {{ number_format($item->total_sales, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500">Belum ada data penjualan.</p>
            @endif
        </div>
    </div>
</div>



{{-- KATEGORI TERLARIS + TRANSAKSI --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="bg-white rounded-[30px] p-6 shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Kategori Terlaris</h2>
            <i data-lucide="folder" class="w-6 h-6 text-red-700"></i>
        </div>

        <div class="space-y-4">
            @if (count($topCategories ?? []) > 0)
                @foreach ($topCategories as $category)
                    <div class="p-4 rounded-2xl bg-[#fafafa] hover:shadow transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-gray-900 leading-tight mb-1">{{ $category->name }}</h3>
                                <p class="text-lg font-semibold text-gray-900 leading-none">Terjual {{ $category->total_qty }} item</p>
                            </div>
                            <div class="text-right flex flex-col justify-end">
                                <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-400 mb-1">Omset</p>
                                <p class="text-sm font-medium text-gray-400">
                                    Rp {{ number_format($category->total_sales, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500">Belum ada data kategori.</p>
            @endif
        </div>
    </div>

    <div class="xl:col-span-2 bg-white rounded-[30px] p-6 shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Transaksi Terbaru</h2>
            <a href="{{ route('orders.index') }}" class="text-red-700 font-semibold hover:underline">Lihat Semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-3">Invoice</th>
                        <th class="py-3">Customer</th>
                        <th class="py-3">Pembayaran</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($latestOrders ?? []) > 0)
                        @foreach ($latestOrders as $order)
                            <tr class="border-b last:border-0 hover:bg-red-50/30 transition">
                                <td class="py-4 font-semibold text-gray-900">{{ $order->invoice_code ?? $order->invoice ?? '-' }}</td>
                                <td class="py-4">
                                    {{ $order->customer_name ?: 'Walk In Customer' }}
                                    @if($order->notes)
                                        <div class="text-xs text-gray-500 mt-1 italic break-words max-w-[200px]">Catatan: {{ $order->notes }}</div>
                                    @endif
                                </td>
                                <td class="py-4 uppercase">{{ $order->payment_method }}</td>
                                <td class="py-4">{{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}</td>
                                <td class="py-4 text-right">
                                    <div class="font-bold text-red-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                    @if($order->discount > 0)
                                        <div class="text-[11px] text-gray-500 mt-1">Diskon: Rp {{ number_format($order->discount, 0, ',', '.') }}</div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const filterSelect = document.getElementById('filterSelect');
    const startDateWrap = document.getElementById('startDateWrap');
    const endDateWrap = document.getElementById('endDateWrap');

    if (filterSelect) {
        filterSelect.addEventListener('change', function () {
            if (this.value === 'custom') {
                startDateWrap.classList.remove('hidden');
                endDateWrap.classList.remove('hidden');
            } else {
                startDateWrap.classList.add('hidden');
                endDateWrap.classList.add('hidden');
            }
        });
    }

    const labels = @json($chartLabels ?? []);
    const revenueData = @json($chartRevenue ?? []);
    const transactionsData = @json($chartTransactions ?? []);
    const itemsData = @json($chartItemsSold ?? []);



    console.log("labels:", labels);
    console.log("revenue:", revenueData);
    console.log("transactions:", transactionsData);
    console.log("items:", itemsData);

    // =========================
    // MAIN SALES CHART
    // =========================
    const salesCtx = document.getElementById('salesChart');

    let salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Omset',
                data: revenueData,
                borderColor: '#b91c1c',
                backgroundColor: 'rgba(239, 68, 68, 0.15)',
                borderWidth: 3,
                tension: 0.35,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    window.switchMainChart = function(type) {
        let label = 'Omset';
        let data = revenueData;

        if (type === 'transactions') {
            label = 'Jumlah Transaksi';
            data = transactionsData;
        } else if (type === 'items') {
            label = 'Item Terjual';
            data = itemsData;
        }

        salesChart.data.datasets[0].label = label;
        salesChart.data.datasets[0].data = data;
        salesChart.update();

        document.getElementById('btnRevenue').className = 'chart-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm';
        document.getElementById('btnTransactions').className = 'chart-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm';
        document.getElementById('btnItems').className = 'chart-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm';

        if (type === 'revenue') {
            document.getElementById('btnRevenue').className = 'chart-btn bg-red-700 text-white px-4 py-2 rounded-xl text-sm';
        } else if (type === 'transactions') {
            document.getElementById('btnTransactions').className = 'chart-btn bg-red-700 text-white px-4 py-2 rounded-xl text-sm';
        } else if (type === 'items') {
            document.getElementById('btnItems').className = 'chart-btn bg-red-700 text-white px-4 py-2 rounded-xl text-sm';
        }
    };


});
</script>

@endsection