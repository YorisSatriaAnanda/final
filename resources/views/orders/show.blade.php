@extends('layouts.admin')

@section('content')
<style>
    @media print {
        @page {
            size: 58mm auto;
            margin: 0mm;
        }
        body {
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .screen-only {
            display: none !important;
        }
        .print-only {
            display: block !important;
            width: 58mm;
            padding: 2mm;
            font-family: 'Courier New', Courier, monospace;
            font-size: 10px;
            color: #000;
            line-height: 1.2;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .mb-1 { margin-bottom: 2px; }
        .mb-2 { margin-bottom: 4px; }
        .dashed-line {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            vertical-align: top;
            padding: 1px 0;
        }
        .w-full { width: 100%; }
    }
    @media screen {
        .print-only {
            display: none;
        }
    }
</style>

<div class="screen-only">
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

                <button onclick="printStruk()"
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

                        @if($order->paid_amount - $order->total_price > 0)
                            <div class="flex justify-between text-gray-600">
                                <span>Kembali</span>
                                <span class="font-semibold">Rp {{ number_format($order->paid_amount - $order->total_price, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@php
    $lineLength = 32;
    $receipt = "";
    
    // Header
    $receipt .= str_pad("Mekarjaya Coffee", $lineLength, " ", STR_PAD_BOTH) . "\n";
    $receipt .= str_pad("Invoice Penjualan", $lineLength, " ", STR_PAD_BOTH) . "\n";
    $receipt .= str_repeat("-", $lineLength) . "\n";
    
    // Info
    $receipt .= "Inv : " . $order->invoice_code . "\n";
    $receipt .= "Date: " . $order->created_at->format('d/m/Y H:i') . "\n";
    $receipt .= "Cust: " . substr($order->customer_name ?: 'Walk In', 0, 26) . "\n";
    $receipt .= "Pay : " . strtoupper($order->payment_method) . "\n";
    $receipt .= "Stat: " . strtoupper($order->status) . "\n";
    $receipt .= str_repeat("-", $lineLength) . "\n";
    
    // Items
    foreach($order->items as $item) {
        $name = substr($item->menu->name, 0, $lineLength);
        $receipt .= $name . "\n";
        
        $qtyPrice = $item->qty . " x " . number_format($item->price, 0, ',', '.');
        $subtotal = number_format($item->subtotal, 0, ',', '.');
        
        $spaceLen = $lineLength - strlen($qtyPrice) - strlen($subtotal);
        if ($spaceLen < 1) $spaceLen = 1;
        
        $receipt .= $qtyPrice . str_repeat(" ", $spaceLen) . $subtotal . "\n";
    }
    
    $receipt .= str_repeat("-", $lineLength) . "\n";
    
    // Summary
    $subtotalLabel = "Subtotal";
    $subtotalVal = number_format($order->total_price, 0, ',', '.');
    $receipt .= $subtotalLabel . str_repeat(" ", max(1, $lineLength - strlen($subtotalLabel) - strlen($subtotalVal))) . $subtotalVal . "\n";
    
    $totalLabel = "Total";
    $totalVal = number_format($order->total_price, 0, ',', '.');
    $receipt .= $totalLabel . str_repeat(" ", max(1, $lineLength - strlen($totalLabel) - strlen($totalVal))) . $totalVal . "\n";
    
    $payLabel = "Bayar";
    $payVal = number_format($order->paid_amount, 0, ',', '.');
    $receipt .= $payLabel . str_repeat(" ", max(1, $lineLength - strlen($payLabel) - strlen($payVal))) . $payVal . "\n";
    
    if ($order->paid_amount - $order->total_price > 0) {
        $changeLabel = "Kembali";
        $changeVal = number_format($order->paid_amount - $order->total_price, 0, ',', '.');
        $receipt .= $changeLabel . str_repeat(" ", max(1, $lineLength - strlen($changeLabel) - strlen($changeVal))) . $changeVal . "\n";
    }
    
    $receipt .= str_repeat("-", $lineLength) . "\n";
    $receipt .= str_pad("Terima Kasih!", $lineLength, " ", STR_PAD_BOTH) . "\n";
    $receipt .= str_pad("Atas Kunjungan Anda", $lineLength, " ", STR_PAD_BOTH) . "\n";
    
    // Feed paper so the text clears the printer tear bar
    $receipt .= "\n\n\n\n\n";
    $receipt .= str_pad(".", $lineLength, " ", STR_PAD_BOTH) . "\n"; // End marker to prevent stripping
@endphp

<pre id="print-content" style="display: none;">{{ $receipt }}</pre>

<script>
    function printStruk() {
        var printWindow = window.open('', '', 'height=600,width=400');
        printWindow.document.write('<html><head><title>Print Receipt</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('@page { margin: 0; size: 58mm auto; }');
        // Use 10px font and 0 padding to ensure 32 chars fit within 58mm
        printWindow.document.write('body { margin: 0; padding: 0; font-family: "Courier New", Courier, monospace; font-size: 10px; color: #000; background: #fff; }');
        // white-space: pre prevents browser from wrapping text, forcing exact 32 char alignment
        printWindow.document.write('pre { margin: 0; padding: 0; white-space: pre; }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<pre>' + document.getElementById('print-content').textContent + '</pre>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        
        setTimeout(function() {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }, 250);
    }
</script>

@endsection