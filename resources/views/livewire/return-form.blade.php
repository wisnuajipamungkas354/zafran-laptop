<div class="max-w-4xl px-4 py-10 mx-auto">
    <h2 class="mb-6 text-2xl font-bold">Form Klaim Garansi</h2>

    <form wire:submit.prevent="submit" class="p-6 space-y-6 bg-white shadow rounded-xl">

        @foreach($order->orderItem as $item)
            <div class="pb-4 mb-4 border-b">
                <label class="flex items-start gap-4">
                    <input type="checkbox" wire:model="returnItems.{{ $item->id }}.return" class="mt-1">
                    <div class="flex-1">
                        <p class="font-semibold">{{ $item->laptop->brand->brand_name ?? '' }} {{ $item->laptop->model }}</p>
                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} | Harga: Rp{{ number_format($item->price_per_item, 0, ',', '.') }}</p>

                        <div class="mt-2" x-show="returnItems.{{ $item->id }}.return">
                            <label>Jumlah yang dikembalikan:</label>
                            <input type="number" min="1" max="{{ $item->quantity }}"
                                   wire:model="returnItems.{{ $item->id }}.quantity"
                                   class="w-24 p-1 mt-1 text-sm border rounded">
                            <br>
                            <label>Grade:</label>
                            <input type="text" wire:model="returnItems.{{ $item->id }}.grade"
                                   class="w-full p-1 mt-1 text-sm border rounded" placeholder="Contoh: mati total, casing lecet">
                        </div>
                    </div>
                </label>
            </div>
        @endforeach

        <div>
            <label>Alasan Klaim Garansi:</label>
            <textarea wire:model="reason" rows="3" class="w-full p-2 border rounded"></textarea>
            @error('reason') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
            Kirim Permintaan Klaim Garansi
        </button>
    </form>
</div>
