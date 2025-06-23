<div class="container px-6 py-10 mx-auto">
    <div class="grid grid-cols-1 gap-8 md:flex md:justify-center md:gap-14">
        {{-- Gambar --}}
        @php
            $laptop->laptop_images = is_array($laptop->laptop_images)
                ? $laptop->laptop_images
                : json_decode($laptop->laptop_images, true);
        @endphp

        <div x-data="{ activeImage: '{{ asset('storage/' . $laptop->laptop_images[0]) }}' }" class="space-y-4">
            {{-- Gambar Utama --}}
            <div class="overflow-hidden border rounded-xl md:max-w-64 md:max-h-72">
                <img :src="activeImage" alt="Gambar Laptop" class="object-contain w-full">
            </div>
        
            {{-- Thumbnail --}}
            <div class="flex space-x-3 overflow-x-auto md:w-full">
                @foreach ($laptop->laptop_images as $image)
                    <img 
                        src="{{ asset('storage/' . $image) }}" 
                        alt="Thumbnail" 
                        class="object-cover transition duration-300 border-2 rounded cursor-pointer h-14 w-14"
                        :class="{ 'border-blue-500': activeImage === '{{ asset('storage/' . $image) }}' }"
                        @click="activeImage = '{{ asset('storage/' . $image) }}'"
                    >
                @endforeach
            </div>
        </div>

        {{-- Info laptop --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-800 uppercase">
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
                        class="px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded-xl">
                    + Keranjang
                </button>
                <button wire:click="buyNow"
                        class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-xl">
                    Beli Langsung
                </button>
            </div>
        </div>
    </div>
    
    {{-- Tabs --}}
    <div class="mt-10" x-data="{ tab: 'deskripsi' }">
        <div class="mb-4 border-b">
            <nav class="flex space-x-6">
                <button @click="tab = 'deskripsi'" :class="tab === 'deskripsi' ? 'text-blue-600 border-b-2 border-blue-600 font-semibold' : 'text-gray-500'" class="pb-2">Deskripsi</button>
                {{-- <button @click="tab = 'ulasan'" :class="tab === 'ulasan' ? 'text-blue-600 border-b-2 border-blue-600 font-semibold' : 'text-gray-500'" class="pb-2">Ulasan</button> --}}
                <button @click="tab = 'garansi'" :class="tab === 'garansi' ? 'text-blue-600 border-b-2 border-blue-600 font-semibold' : 'text-gray-500'" class="pb-2">Garansi</button>
            </nav>
        </div>

        {{-- Deskripsi --}}
        <div x-show="tab === 'deskripsi'" class="space-y-2">
            <p><strong>Brand:</strong> {{ $laptop->brand->brand_name }}</p>
            <p><strong>Model:</strong> {{ $laptop->model }}</p>
            <p><strong>Processor:</strong> {{ $laptop->processor }}</p>
            <p><strong>RAM:</strong> {{ $laptop->ram }}</p>
            <p><strong>Storage:</strong> {{ $laptop->storage }}</p>
            <p><strong>Graphics Card:</strong> {{ $laptop->graphics_card ?? 'Default' }}</p>
            <p><strong>Screen Size:</strong> {{ $laptop->screen_size }}</p>
            <p><strong>Grade :</strong> {{ $laptop->grade }}</p>
            {!! $laptop->description !!}
        </div>

        {{-- Ulasan --}}
        {{-- <div x-show="tab === 'ulasan'" class="text-gray-600">
            <p>Belum ada ulasan untuk produk ini.</p>
        </div> --}}

        {{-- Garansi --}}
        <div x-show="tab === 'garansi'" class="text-gray-600">
            <p>
                - Garansi dapat diklaim selama <strong>14 hari</strong> terhitung sejak laptop diterima oleh pelanggan.<br>
                - Garansi tidak berlaku jika terjadi <em>human error</em> seperti tertindih, terkena air, terjatuh, dan sejenisnya.<br>
                - Garansi <strong>tidak dapat dikembalikan berupa uang</strong>, hanya berlaku untuk <strong>tukar unit</strong> atau <strong>perbaikan part</strong>.
            </p>
        </div>
    </div>
</div>


