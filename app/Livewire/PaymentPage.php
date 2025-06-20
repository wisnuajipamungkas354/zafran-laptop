<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentPage extends Component
{
    public $order;
    public $snapToken;

    public function mount(Order $order)
    {
        if ($order->payment_status === 'paid') {
            return redirect()->route('katalog')->with('success', 'Pesanan sudah dibayar.');
        }

        $this->order = $order;

        // Midtrans setup
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Snap Token
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->id,
                'gross_amount' => (int)$order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->customer->first_name,
                'last_name' => $order->customer->last_name,
                'email' => $order->customer->email,
                'phone_number' => $order->customer->phone_number,
            ],
        ];

        $this->snapToken = Snap::getSnapToken($params);
    }

    public function render()
    {
        return view('livewire.payment-page');
    }
}
