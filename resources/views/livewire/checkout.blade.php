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

        <div class="flex items-center gap-3 mt-4">
            <span>
                <label for="selected_address_id" class="block mb-1 font-semibold">Pilih Alamat Tersimpan:</label>
                <select wire:model="selected_address_id" class="w-full p-2 border rounded">
                    <option value="">-- Pilih Alamat --</option>
                    @foreach($addresses as $addr)
                        <option value="{{ $addr->id }}">{{ $addr->label }} - {{ $addr->address }}</option>
                    @endforeach
                </select>
            </span>
            <button type="button"
                wire:click="$set('showAddAddressModal', true)"
                class="mt-6 text-sm text-blue-600 hover:underline">
                + Tambah Alamat Baru
            </button>
        </div>
        


        <button wire:click="placeOrder"
                class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-xl">
            Buat Pesanan & Bayar
        </button>
    </div>
    <!-- Modal -->
    @if($showAddAddressModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="w-full max-w-md p-6 bg-white rounded-xl">
                <h3 class="mb-4 text-lg font-bold">Tambah Alamat Baru</h3>
    
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-semibold">Label (Rumah, Kantor, dll)</label>
                    <input type="text" wire:model="new_address.label" class="w-full p-2 border rounded" placeholder="Masukkan label">
                    @error('new_address.label') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
    
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-semibold">Alamat Lengkap</label>
                    <textarea wire:model="new_address.address" rows="3" class="w-full p-2 border rounded" placeholder="Masukkan alamat lengkap"></textarea>
                    @error('new_address.address') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
    
                <div class="flex justify-end gap-2">
                    <button wire:click="$set('showAddAddressModal', false)"
                        class="px-4 py-2 text-black bg-gray-300 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button wire:click="saveNewAddress"
                        class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">
                        Simpan Alamat
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>



