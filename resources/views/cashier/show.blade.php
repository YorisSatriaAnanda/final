@extends('layouts.admin')

@section('content')
<style>
    @media print {
        /* Hide UI elements */
        aside, nav, .lg\:hidden, .flex.gap-3, button, a.bg-red-700, .text-gray-500.mt-1 {
            display: none !important;
        }

        /* Reset layout for 58mm */
        body, .min-h-screen, .flex, main {
            background: white !important;
            margin: 0 !important;
            padding: 0 !important;
            display: block !important;
            width: 58mm !important;
        }

        .max-w-5xl {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Receipt styling */
        .bg-white {
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
            width: 58mm !important;
        }

        .p-8 {
            padding: 5mm 2mm !important;
        }

        /* Typography for thermal paper */
        h1, h2, h3, p, span, td, th {
            font-family: 'Courier New', Courier, monospace !important;
            color: black !important;
        }

        h2.text-3xl {
            font-size: 14pt !important;
            text-align: center !important;
            margin-bottom: 2mm !important;
        }

        .text-3xl.font-bold, .text-xl.font-bold {
            font-size: 11pt !important;
        }

        .text-sm, .text-gray-500 {
            font-size: 9pt !important;
        }

        table {
            width: 100% !important;
            font-size: 9pt !important;
            border-collapse: collapse !important;
        }

        th, td {
            padding: 1mm 0 !important;
            border-bottom: 1px dashed #000 !important;
        }

        .border-b {
            border-bottom: 1px dashed #000 !important;
        }

        .flex.justify-between {
            display: flex !important;
            justify-content: space-between !important;
            margin-bottom: 1mm !important;
        }

        /* Force black text for contrast */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color: black !important;
        }

        @page {
            size: 58mm auto;
            margin: 0;
        }

        /* Divider */
        .receipt-divider {
            border-top: 1px dashed #000;
            margin: 3mm 0;
        }

        .print-only {
            display: block !important;
        }
    }

    .print-only {
        display: none;
    }
</style>

    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detail Transaksi</h1>
                <p class="text-gray-500 mt-1">Invoice pembayaran customer.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('cashier.index') }}"
                   class="bg-red-700 text-white px-5 py-3 rounded-2xl hover:bg-red-800 transition shadow-md">
                    + Transaksi Baru
                </a>

                <button onclick="window.print()"
                        class="bg-gray-900 text-white px-5 py-3 rounded-2xl hover:bg-black transition shadow-md">
                    Print Struk
                </button>
            </div>
        </div>

        <div class="bg-white rounded-[30px] shadow-md overflow-hidden">
            <div class="p-8 border-b border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-bold text-red-700">Mekarjaya Coffee</h2>
                        <p class="text-gray-500 mt-2">Invoice Kasir</p>
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
                            <span>Subtotal</span>
                            <span class="font-semibold">Rp {{ number_format($order->total_price + $order->discount, 0, ',', '.') }}</span>
                        </div>

                        @if($order->discount > 0)
                            <div class="flex justify-between text-gray-600">
                                <span>
                                    Diskon 
                                    @if($order->discount_type === 'percent')
                                        ({{ (float)$order->discount_value }}%)
                                    @endif
                                </span>
                                <span class="font-semibold">- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between text-gray-900 font-bold border-t pt-4">
                            <span>Total Akhir</span>
                            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between text-gray-600">
                            <span>Bayar</span>
                            <span class="font-semibold">Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</span>
                        </div>

                    </div>
                </div>

                {{-- Footer Struk (Print Only) --}}
                <div class="print-only mt-8 text-center" style="font-family: 'Courier New', Courier, monospace; font-size: 9pt;">
                    <p class="receipt-divider"></p>
                    <p class="font-bold">Terima Kasih!</p>
                    <p>Atas Kunjungan Anda</p>
                    <p>{{ date('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

@endsection