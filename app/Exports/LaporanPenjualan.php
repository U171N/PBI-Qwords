<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPenjualan implements FromCollection
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $filteredOrders = $this->orders->filter(function ($order) use ($currentMonth, $currentYear) {
            return $order->created_at->month == $currentMonth && $order->created_at->year == $currentYear;
        });

        $data = $filteredOrders->flatMap(function ($order) {
            return $order->orderItems->map(function ($orderItem) use ($order) {
                return [
                    'ID Pemesanan' => '#' . $order->order_id,
                    'Nama Product' => $orderItem->product->name,
                    'Nama Customer' => $order->user->name,
                    'Tanggal Pembelian' => $order->created_at->format('d M Y'),
                    'Harga' => 'Rp' . number_format($order->total_amount, 2),
                    'Status' => $this->getStatusText($order->status),
                ];
            });
        });

        return new Collection($data);
    }


    //menambahkan heading atau title
    public function headings(): array
    {
        return [
            'ID Pemesanan',
            'Nama Product',
            'Nama Customer',
            'Tanggal Pembelian',
            'Harga',
            'Status',
        ];
    }

    //styling

    public function styles(Worksheet $sheet)
    {
        return [
            // Apply styles to the header row
            1 => [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFFF00',
                    ],
                ],
            ],
        ];
    }


    private function getStatusText($status)
    {
        switch ($status) {
            case 0:
                return 'Sedang Diproses';
            case 1:
                return 'Sedang Dikirim';
            case 2:
                return 'Sudah Diterima';
            case 3:
                return 'Dibatalkan';
            default:
                return 'Status tidak Valid';
        }
    }
}

