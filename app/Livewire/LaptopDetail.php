<?php

namespace App\Livewire;

use App\Models\Laptop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LaptopDetail extends Component
{
    public $laptop;
    public $quantity = 1;
    public $subtotal = 0;

    public function mount($id)
    {
        $this->laptop = Laptop::with('brand')->findOrFail($id);
        $this->calculateSubtotal();
    }

    public function updatedQuantity()
    {
        $this->calculateSubtotal();
    }

    public function calculateSubtotal()
    {
        $this->subtotal = $this->laptop->price * $this->quantity;
    }

    public function addToCart()
    {
        // Tambahkan ke keranjang (shopping_carts)
        // Pastikan customer sudah login
    }

    public function buyNow()
    {
        if(!Auth::guard('customer')->check()) {
            return redirect()->route('login.customer');
        }

        if ($this->quantity > $this->laptop->stock) {
            $this->addError('quantity', 'Jumlah melebihi stok tersedia.');
            return;
        }

        return redirect()->route('checkout', [
            'buy_now' => 1,
            'laptop_id' => $this->laptop->id,
            'quantity' => $this->quantity,
        ]);
    }

    public function render()
    {
        return view('livewire.laptop-detail');
    }
}
