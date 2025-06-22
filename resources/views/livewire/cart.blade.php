<div class="w-full p-4 mx-auto space-y-6">
    <div class="">
        <h2 class="text-3xl font-bold text-gray-800">Keranjang Anda</h2>
    </div>

    @forelse($cartItems as $item)
        <div class="flex items-center justify-between gap-8 p-4 border rounded">
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/' . $item->laptop->laptop_images[0]) }}" alt="" class="object-cover w-24 h-24 rounded">
                <div>
                    <div class="font-semibold">{{ $item->laptop->brand->brand_name }} {{ $item->laptop->model }}</div>
                    <div class="text-sm text-gray-500">Rp{{ number_format($item->laptop->price, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button wire:click="decrease({{ $item->id }})" class="px-2 py-1 bg-gray-200 rounded">-</button>
                <span>{{ $item->quantity }}</span>
                <button wire:click="increase({{ $item->id }})" class="px-2 py-1 bg-gray-200 rounded">+</button>
            </div>

            <div class="text-right">
                <div>Subtotal:</div>
                <div class="font-semibold">Rp{{ number_format($item->laptop->price * $item->quantity, 0, ',', '.') }}</div>
                <button wire:click="removeItem({{ $item->id }})" class="mt-2 text-sm text-red-500">Hapus</button>
            </div>
        </div>
    @empty
        <div class="text-gray-500">Keranjang kosong.</div>
    @endforelse

    @if(count($cartItems))
        <div class="mt-4 text-right">
            <div class="text-lg font-bold">Total: Rp{{ number_format($total, 0, ',', '.') }}</div>
            <a href="{{ route('checkout') }}" wire:navigate class="inline-block px-6 py-2 mt-2 text-white bg-green-600 rounded">Checkout</a>
        </div>
    @endif
</div>
