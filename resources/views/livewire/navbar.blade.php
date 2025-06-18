<div class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <a href="{{ route('katalog') }}" class="text-2xl font-bold text-black-600">Zafran Laptop</a>

        <div class="flex gap-3">
            <input type="text" wire:model.live="search"
                   placeholder="Cari laptop..."
                   class="w-full md:w-1/3 px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300" />
    
            <select wire:model.live="selectedBrand"
                    class="w-full md:w-auto px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300">
                <option value="">Semua Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                @endforeach
            </select>
    
            <div class="flex items-center space-x-2">
                <input type="number" wire:model.live="minPrice" placeholder="Min"
                       class="w-24 px-2 py-1 border rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300">
                <span>-</span>
                <input type="number" wire:model.live="maxPrice" placeholder="Max"
                       class="w-24 px-2 py-1 border rounded-lg text-sm focus:outline-none focus:ring focus:border-blue-300">
            </div>
        </div>
    </div>
</div>
