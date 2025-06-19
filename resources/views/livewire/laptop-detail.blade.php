<div class="container px-6 py-10 mx-auto">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
        {{-- Gambar utama --}}
        <div class="flex justify-center gap-2">
            <img src="{{ asset('storage/' . $laptop->laptop_images[0] ?? 'img/default.png') }}"
                 class="order-2 object-cover w-64 shadow h-80 rounded-xl" alt="Gambar Laptop">

            {{-- Thumbnail --}}
            <div class="flex flex-col order-1 gap-3 mt-4">
                @foreach($laptop->laptop_images as $image)
                    <img src="{{ asset('storage/' . $image) }}"
                         class="object-cover w-20 h-16 border rounded cursor-pointer" alt="Thumbnail">
                @endforeach
            </div>
        </div>

        {{-- Info laptop --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                {{ $laptop->brand->brand_name ?? '' }} {{ $laptop->model }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Processor: {{ $laptop->processor }} | RAM: {{ $laptop->ram }} | Storage: {{ $laptop->storage }}
            </p>

            <p class="mt-4 text-2xl font-semibold text-blue-600">
                Rp{{ number_format($laptop->price, 0, ',', '.') }}
            </p>

            {{-- Stok --}}
            <p class="mt-2 text-sm text-gray-500">Stok tersedia: {{ $laptop->stock }}</p>

            {{-- Input jumlah --}}
            <div class="flex items-center mt-4">
                <label class="mr-2">Jumlah:</label>
                <input type="number" wire:model.live="quantity" min="1"
                       max="{{ $laptop->stock }}"
                       class="w-20 px-2 py-1 border rounded">
            </div>

            {{-- Subtotal --}}
            <p class="mt-2 text-gray-700">
                Subtotal: <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
            </p>

            {{-- Tombol --}}
            <div class="flex gap-3 mt-5">
                <button wire:click="addToCart"
                        class="px-4 py-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded-xl">
                    + Keranjang
                </button>
                <button wire:click="buyNow"
                        class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-xl">
                    Beli Langsung
                </button>
            </div>
        </div>
    </div>
    <hr class="my-3"/>
    {{-- Deskripsi --}}
    <div class="">
        <h3 class="mb-2 text-lg font-semibold">Deskripsi Produk</h3>
            {!! $laptop->description !!}
    </div>
</div>
