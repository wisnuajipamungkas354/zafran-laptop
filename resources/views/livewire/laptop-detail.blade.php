<div class="container mx-auto px-6 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Gambar utama --}}
        <div>
            <img src="{{ asset('storage/' . $laptop->laptop_images[0] ?? 'img/default.png') }}"
                 class="w-full h-80 object-cover rounded-xl shadow" alt="Gambar Laptop">

            {{-- Thumbnail --}}
            <div class="flex gap-3 mt-4">
                @foreach($laptop->laptop_images as $image)
                    <img src="{{ asset('storage/' . $image) }}"
                         class="w-20 h-16 object-cover rounded cursor-pointer border" alt="Thumbnail">
                @endforeach
            </div>
        </div>

        {{-- Info laptop --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                {{ $laptop->brand->brand_name ?? '' }} {{ $laptop->model }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                Processor: {{ $laptop->processor }} | RAM: {{ $laptop->ram }} | Storage: {{ $laptop->storage }}
            </p>

            <p class="text-blue-600 text-2xl font-semibold mt-4">
                Rp{{ number_format($laptop->price, 0, ',', '.') }}
            </p>

            {{-- Stok --}}
            <p class="text-sm mt-2 text-gray-500">Stok tersedia: {{ $laptop->stock }}</p>

            {{-- Input jumlah --}}
            <div class="flex items-center mt-4">
                <label class="mr-2">Jumlah:</label>
                <input type="number" wire:model.live="quantity" min="1"
                       max="{{ $laptop->stock }}"
                       class="w-20 border rounded px-2 py-1">
            </div>

            {{-- Subtotal --}}
            <p class="mt-2 text-gray-700">
                Subtotal: <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
            </p>

            {{-- Tombol --}}
            <div class="flex gap-3 mt-5">
                <button wire:click="addToCart"
                        class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl">
                    Tambah ke Keranjang
                </button>
                <button wire:click="buyNow"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl">
                    Beli Langsung
                </button>
            </div>
        </div>
    </div>

    {{-- Deskripsi --}}
    <div class="mt-10">
        <h3 class="text-lg font-semibold mb-2">Deskripsi Produk</h3>
        <p class="text-gray-700 leading-relaxed">
            {{ $laptop->description }}
        </p>
    </div>
</div>
