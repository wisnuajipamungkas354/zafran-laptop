<div class="w-full px-6 py-10 mx-auto">
    <h2 class="mb-6 text-2xl font-bold">Checkout</h2>

    @error('error')
        <div class="p-3 mb-4 text-red-600 bg-red-100 rounded">{{ $message }}</div>
    @enderror

    <div class="p-6 space-y-4 bg-white shadow rounded-xl">
        @forelse($cartItems as $item)
            <div class="flex items-center justify-between pb-4 border-b">
                <div>
                    <h3 class="text-lg font-semibold uppercase">{{ $item->laptop->brand->brand_name }} {{ $item->laptop->model }}</h3>
                    <p class="text-sm text-gray-500">
                        {{ $item->quantity }} x Rp{{ number_format($item->laptop->price, 0, ',', '.') }}
                    </p>
                </div>
                <p class="font-semibold text-right text-blue-600">
                    Rp{{ number_format($item->laptop->price * $item->quantity, 0, ',', '.') }}
                </p>
            </div>
        @empty
            <p class="text-gray-500">Keranjang kosong.</p>
        @endforelse

        <div class="pt-4 border-t">
            <h4 class="text-xl font-semibold">Total: Rp{{ number_format($total_amount, 0, ',', '.') }}</h4>
        </div>

        <div class="mt-4">
            <label for="shipping" class="block mb-1 font-semibold">Alamat Pengiriman:</label>
            <textarea wire:model="shipping_address" rows="3" class="w-full p-2 border rounded"></textarea>
            @error('shipping_address') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <button wire:click="placeOrder"
                class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-xl">
            Buat Pesanan & Bayar
        </button>
    </div>
</div>
