<?php

namespace App\Livewire;

use App\Models\Laptop;
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
        // Arahkan ke checkout langsung
    }

    public function render()
    {
        return view('livewire.laptop-detail');
    }
}
