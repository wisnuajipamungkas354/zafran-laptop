<div class="container mx-auto px-6 py-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Katalog Laptop</h1>
        {{-- @livewire('navbar') --}}
    </div>

    {{-- Grid katalog laptop --}}
    @if($laptops->isEmpty())
        <div class="text-center text-gray-500 mt-8">
            Tidak ada laptop yang ditemukan.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($laptops as $laptop)
                <div class="bg-white shadow rounded-2xl overflow-hidden hover:shadow-md transition">
                    <a href="{{ route('katalog.detail', $laptop->id) }}" wire:navigate>
                        <img src="{{ asset('storage/' . $laptop->laptop_images[0] ?? 'img/default.png') }}"
                             alt="{{ $laptop->model }}"
                             class="h-48 w-full object-cover">
                    </a>

                    <div class="p-4">
                        <h3 class="text-sm text-gray-600 font-semibold uppercase">
                            {{ $laptop->brand->brand_name ?? 'Unknown Brand' }}
                        </h3>
                        <p class="text-lg font-bold text-gray-800 uppercase">
                            {{ $laptop->model }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $laptop->processor }} | {{ $laptop->ram }} RAM
                        </p>
                        <p class="text-blue-600 font-semibold text-lg mt-2">
                            Rp{{ number_format($laptop->price, 0, ',', '.') }}
                        </p>
                        <a href="{{ route('katalog.detail', $laptop->id) }}" wire:navigate
                           class="mt-3 inline-block w-full bg-blue-600 text-white text-sm py-2 rounded-xl text-center hover:bg-blue-700 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
