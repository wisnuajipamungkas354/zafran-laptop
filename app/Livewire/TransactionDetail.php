<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class TransactionDetail extends Component
{
    public $order;

    public function mount($id)
    {
        $this->order = Order::with(['orderItem.laptop','delivery'])
            ->where('customer_id', auth('customer')->id())
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.transaction-detail');
    }
}
