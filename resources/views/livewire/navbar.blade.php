<div class="sticky top-0 z-50 flex justify-between bg-white shadow">
    <div class="container flex flex-col gap-4 px-6 py-4 mx-auto md:flex-row md:items-center md:justify-between">
        <a href="{{ route('katalog') }}" wire:navigate class="text-2xl font-bold text-black-600">
            {{-- <img src="{{ asset('img/logo.png') }}" class="w-12 h-12" /> --}}
            <span class="text-2xl text-orange-500">Zafran</span> Laptop
        </a>

        <div class="flex gap-3">
            <input type="text" wire:model.live="search"
                   placeholder="Cari laptop..."
                   class="w-full px-4 py-2 border rounded-lg shadow-sm md:w-1/3 focus:outline-none focus:ring focus:border-blue-300" />
    
            <select wire:model.live="selectedBrand"
                    class="w-full px-3 py-2 text-sm border rounded-lg md:w-auto focus:outline-none focus:ring focus:border-blue-300">
                <option value="">Semua Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                @endforeach
            </select>
    
            <div class="flex items-center space-x-2">
                <input type="number" wire:model.live="minPrice" placeholder="Min"
                       class="w-24 px-2 py-2 text-sm border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                <span>-</span>
                <input type="number" wire:model.live="maxPrice" placeholder="Max"
                       class="w-24 px-2 py-2 text-sm border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            </div>

        </div>
        <div class="flex items-center gap-1">
            @auth('customer')
            <a href="{{ route('transaksi') }}" class="text-sm text-gray-700 hover:text-blue-600">Transaksi</a>
            <div class="flex items-center gap-4">
                <span class="text-gray-700">Hi, {{ auth('customer')->user()->first_name }}</span>
                @livewire('logout-customer')
            </div>
            @else
            <a href="{{ route('register.customer') }}" class="text-sm text-blue-600 hover:underline">Daftar</a>
            <a href="{{ route('login.customer') }}" wire:navigate class="px-4 py-1 text-white bg-blue-600 border border-blue-600 rounded">Login</a>
            @endauth
        </div>
    </div>
</div>
