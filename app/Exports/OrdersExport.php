<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            'Invoice',
            'Customer',
            'Metode Pembayaran',
            'Status',
            'Total Harga',
            'Diskon',
            'Total Item',
            'Detail Menu',
            'Catatan',
            'Tanggal',
        ];
    }

    public function map($order): array
    {
        $menuDetails = $order->items->map(function($item) {
            return ($item->menu->name ?? 'Menu Terhapus') . ' (' . $item->qty . 'x)';
        })->implode(', ');

        return [
            $order->invoice_code,
            $order->customer_name ?: 'Walk In Customer',
            strtoupper($order->payment_method),
            strtoupper($order->status),
            (int) $order->total_price,
            (int) $order->discount,
            $order->items->sum('qty'),
            $menuDetails,
            $order->notes ?: '-',
            $order->created_at->format('d-m-Y H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
