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
    public $returnItem = [];

    public function mount(Order $order)
    {
        $this->order = $order->load('orderItem.laptop');

        foreach ($this->order->orderItem as $item) {
            $this->returnItem[$item->id] = [
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
            'returnItem.*.condition' => 'required_if:returnItem.*.return,true|min:3',
        ]);

        $retur = LaptopReturn::create([
            'order_id' => $this->order->id,
            'customer_id' => auth('customer')->id(),
            'return_date' => now(),
            'reason' => $this->reason,
        ]);

        foreach ($this->order->orderItem as $item) {
            if (!($this->returnItem[$item->id]['return'] ?? false)) continue;

            $qty = $this->returnItem[$item->id]['quantity'];
            $subtotal = $qty * $item->price_per_item;

            LaptopReturnItem::create([
                'laptop_return_id' => $retur->id,
                'laptop_id' => $item->laptop_id,
                'quantity' => $qty,
                'price_at_return' => $item->price_per_item,
                'condition_on_return' => $this->returnItem[$item->id]['condition'],
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
