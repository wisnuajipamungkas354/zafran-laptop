<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class TransactionHistory extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::where('customer_id', auth('customer')->id())
                             ->orderByDesc('id')
                             ->get();
    }

    public function render()
    {
        return view('livewire.transaction-history');
    }
}
