<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download($id)
    {
        $order = Order::with('orderItem.laptop.brand')
            ->where('customer_id', auth('customer')->id())
            ->where('order_number', '=', $id)
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.invoice', compact('order'));

        return $pdf->stream('invoice-order-' . $order->order_number . '.pdf');
    }
}
