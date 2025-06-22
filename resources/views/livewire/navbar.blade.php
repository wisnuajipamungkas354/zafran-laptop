<div class="sticky top-0 z-50 bg-white shadow">
    <div class="container flex flex-col justify-between gap-5 px-6 py-4 mx-auto md:flex-row md:items-center">
        
        {{-- Logo --}}
        <a href="{{ route('katalog') }}" wire:navigate class="text-xl font-bold text-orange-500">
            Zafran <span class="text-black">Laptop</span>
        </a>

        {{-- Filter & Pencarian --}}
        <div class="flex flex-col items-center flex-1 w-full gap-3 sm:flex-row sm:justify-center">
            <input type="text" wire:model.live="search" placeholder="Cari laptop..."
                   class="px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300" />

            <select wire:model.live="selectedBrand"
                    class="w-full px-3 py-2 text-sm border rounded-lg sm:w-auto focus:outline-none focus:ring focus:border-blue-300">
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

        {{-- Auth --}}
        <div class="flex items-center gap-4 whitespace-nowrap">
            @auth('customer')
                {{-- Icon Keranjang --}}
                <a href="{{ route('cart') }}" wire:navigate class="relative hidden text-gray-600 hover:text-blue-600 md:block">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    @if($cartCount > 0)
                        <span class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-600 rounded-full -top-2 -right-2">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                

                {{-- Icon Transaksi --}}
                <a href="{{ route('transaksi') }}" wire:navigate class="relative hidden text-gray-600 hover:text-blue-600 md:block">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                </a>

                {{-- Nama dan Logout --}}
                <div class="items-center hidden gap-2 text-gray-700 sm:flex">
                    <span>Hi, {{ auth('customer')->user()->first_name }}</span>
                    @livewire('logout-customer')
                </div>
            @else
                <a href="{{ route('register.customer') }}" class="text-sm text-blue-600 hover:underline">Daftar</a>
                <a href="{{ route('login.customer') }}" wire:navigate
                   class="px-4 py-1 text-white bg-blue-600 border border-blue-600 rounded">
                    Login
                </a>
            @endauth
        </div>
    
        {{-- Dropdown menu --}}
        <div class="mt-2 space-y-2 md:hidden">
            <a href="{{ route('cart') }}" class="block text-center text-gray-700 hover:text-blue-600">
                <i data-lucide="shopping-cart" class="inline w-5 h-5"></i>
                Keranjang
            </a>
            <a href="{{ route('transaksi') }}" class="block text-center text-gray-700 hover:text-blue-600">
                <i data-lucide="receipt" class="inline w-5 h-5"></i>
                Transaksi
            </a>
            {{-- Tambahkan lainnya di sini --}}
        </div>

    </div>
</div>

