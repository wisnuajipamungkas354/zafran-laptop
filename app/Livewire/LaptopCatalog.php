<?php

namespace App\Livewire;

use App\Models\Laptop;
use Livewire\Component;

class LaptopCatalog extends Component
{
    public $search = '';
    public $selectedBrand = '';
    public $minPrice = '';
    public $maxPrice = '';

    protected $listeners = ['filterUpdated' => 'handleFilterUpdated'];

    public function handleFilterUpdated($filters)
    {
        $this->search = $filters['search'] ?? '';
        $this->selectedBrand = $filters['selectedBrand'] ?? '';
        $this->minPrice = $filters['minPrice'] ?? '';
        $this->maxPrice = $filters['maxPrice'] ?? '';
    }

    public function render()
    {
        $laptops = Laptop::with('brand')
        ->when($this->search, fn($query) =>
            $query->where('model', 'like', "%{$this->search}%")
                  ->orWhere('processor', 'like', "%{$this->search}%")
        )
        ->when($this->selectedBrand, fn($query) =>
            $query->where('brand_id', $this->selectedBrand)
        )
        ->when($this->minPrice, fn($query) =>
            $query->where('price', '>=', $this->minPrice)
        )
        ->when($this->maxPrice, fn($query) =>
            $query->where('price', '<=', $this->maxPrice)
        )
        ->latest()
        ->get();

    return view('livewire.laptop-catalog', compact('laptops'));
    }
}
