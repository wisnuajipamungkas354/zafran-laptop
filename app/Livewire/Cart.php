<?php

namespace App\Livewire;

use App\Models\ShoppingCart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{
    public $cartItems = [];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = ShoppingCart::with('laptop')
            ->where('customer_id', Auth::guard('customer')->id())
            ->get();
    }

    public function increase($cartId)
    {
        $item = ShoppingCart::findOrFail($cartId);
        if ($item->quantity < $item->laptop->stock) {
            $item->quantity += 1;
            $item->save();
        }
        $this->loadCart();
    }

    public function decrease($cartId)
    {
        $item = ShoppingCart::findOrFail($cartId);
        if ($item->quantity > 1) {
            $item->quantity -= 1;
            $item->save();
        }
        $this->loadCart();
    }

    public function removeItem($cartId)
    {
        ShoppingCart::where('id', $cartId)->delete();
        $this->loadCart();
    }

    public function render()
    {
        $total = $this->cartItems->sum(fn($item) => $item->laptop->price * $item->quantity);
        return view('livewire.cart', compact('total'));
    }
}
