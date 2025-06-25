<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderExportController extends Controller
{
    public function download()
    {
            // Ambil filter dari session flash (dikirim lewat tombol Filament)
        $filters = session('filter_export', []);

        $orders = Order::query();

        if (!empty($filters['payment_status'])) {
            $orders->where('payment_status', $filters['payment_status']);
        }

        if (!empty($filters['order_status'])) {
            $orders->where('order_status', $filters['order_status']);
        }

        if (!empty($filters['start']) && !empty($filters['end'])) {
            $orders->whereBetween('created_at', [
                $filters['start'] . ' 00:00:00',
                $filters['end'] . ' 23:59:59',
            ]);
        }

        $orders = $orders->with('customer')->orderBy('created_at', 'desc')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.orders-pdf', compact('orders'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('laporan-orders.pdf');
    }

    public function excel()
    {
        $filters = session('filter_export', []);

        return Excel::download(new OrderExport($filters), 'laporan-orders.xlsx');
    }
}
