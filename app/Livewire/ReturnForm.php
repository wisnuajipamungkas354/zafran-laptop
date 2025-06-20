<?php

namespace App\Livewire;

use App\Models\LaptopReturn;
use App\Models\LaptopReturnItem;
use App\Models\Order;
use Livewire\Component;

class ReturnForm extends Component
{
    public $order;
    public $reason;
    public $returnItems = [];

    public function mount(Order $order)
    {
        $this->order = $order->load('orderItems.laptop');

        foreach ($this->order->orderItems as $item) {
            $this->returnItems[$item->id] = [
                'return' => false,
                'quantity' => $item->quantity,
                'condition' => '',
            ];
        }
    }

    public function submit()
    {
        $this->validate([
            'reason' => 'required|min:10',
            'returnItems.*.condition' => 'required_if:returnItems.*.return,true|min:3',
        ]);

        $retur = LaptopReturn::create([
            'order_id' => $this->order->id,
            'customer_id' => auth('customer')->id(),
            'return_date' => now(),
            'reason' => $this->reason,
            'return_status' => 'pending',
            'refund_status' => 'unpaid',
        ]);

        foreach ($this->order->orderItems as $item) {
            if (!($this->returnItems[$item->id]['return'] ?? false)) continue;

            $qty = $this->returnItems[$item->id]['quantity'];
            $subtotal = $qty * $item->price_per_item;

            LaptopReturnItem::create([
                'laptop_return_id' => $retur->id,
                'laptop_id' => $item->laptop_id,
                'quantity' => $qty,
                'price_at_return' => $item->price_per_item,
                'condition_on_return' => $this->returnItems[$item->id]['condition'],
                'subtotal_returned' => $subtotal,
            ]);
        }

        return redirect()->route('transaksi')->with('success', 'Permintaan retur berhasil dikirim.');
    }

    public function render()
    {
        return view('livewire.return-form');
    }
}
