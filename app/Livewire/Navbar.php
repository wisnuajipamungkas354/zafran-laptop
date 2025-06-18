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
