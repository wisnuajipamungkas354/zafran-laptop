<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection(): Collection
    {
        $orders = Order::query();

        if (!empty($this->filters['payment_status'])) {
            $orders->where('payment_status', $this->filters['payment_status']);
        }

        if (!empty($this->filters['order_status'])) {
            $orders->where('order_status', $this->filters['order_status']);
        }

        if (!empty($this->filters['start']) && !empty($this->filters['end'])) {
            $orders->whereBetween('created_at', [
                $this->filters['start'] . ' 00:00:00',
                $this->filters['end'] . ' 23:59:59',
            ]);
        }

        return $orders->with('customer')->get()->map(function ($order) {
            $paymentStatusMap = [
                'pending' => 'Belum Dibayar',
                'paid' => 'Dibayar',
                'canceled' => 'Dibatalkan',
            ];
        
            $orderStatusMap = [
                'pending' => 'Menunggu Pembayaran',
                'processing' => 'Diproses Admin',
                'shipped' => 'Sedang Dikirim',
                'delivered' => 'Sudah Diterima',
                'canceled' => 'Dibatalkan',
            ];
        
            return [
                $order->order_number,
                $order->created_at->format('d-m-Y'),
                $order->customer->first_name ?? '-',
                $order->total_amount,
                $paymentStatusMap[$order->payment_status] ?? '-',
                $orderStatusMap[$order->order_status] ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['Nomor Pesanan', 'Tanggal', 'Customer', 'Total', 'Status Pembayaran', 'Status Order'];
    }
}
