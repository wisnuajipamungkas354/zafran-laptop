<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;

class Navbar extends Component
{
    public $search = '';
    public $selectedBrand = '';
    public $minPrice = '';
    public $maxPrice = '';
    public $cartCount = 0;

    protected $listeners = ['updateCartBadge' => 'render'];

    public function mount()
    {
        if (auth('customer')->check()) {
            $this->cartCount = \App\Models\ShoppingCart::where('customer_id', auth('customer')->id())->count();
        }
    }

    public function updated()
    {
        $this->dispatch('filterUpdated', [
            'search' => $this->search,
            'selectedBrand' => $this->selectedBrand,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
        ]);
    }

    public function render()
    {
        $brands = Brand::orderBy('brand_name')->get();

        return view('livewire.navbar', compact('brands'));
    }
}
