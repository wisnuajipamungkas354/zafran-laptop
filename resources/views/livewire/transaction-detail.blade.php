<div class="flex flex-col w-full gap-4 px-4 py-10 mx-auto space-y-8">

    {{-- Judul + Tombol Aksi --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Detail Transaksi #{{ $order->id }}</h2>
            <p class="text-sm text-gray-500">Tanggal Pesanan: {{ $order->created_at->format('d M Y H:i') }}</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row">
            @if($order->payment_status == 'paid')
                <a href="{{ route('transaksi.invoice', $order->id) }}"
                target="_blank"
                class="px-4 py-2 text-sm text-white bg-blue-600 rounded-xl hover:bg-blue-700">
                    Download Invoice
                </a>
            @else
                <button wire:click="payment" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-xl hover:bg-blue-700" >Bayar Ulang</button>
            @endif
            
            {{-- @if(!$order->delivery || !$order->delivery->delivery_date) --}}
              
            {{-- @elseif($order->isReturnable())
                <a href="{{ route('retur.form', $order->id) }}"
                   class="px-4 py-2 text-sm text-white bg-red-600 rounded-xl hover:bg-red-700">
                    ♻️ Klaim Garansi
                </a>
            @else
                <p class="text-sm italic text-gray-500">
                    Masa garansi (14 hari) telah berakhir.
                </p> --}}
            {{-- @endif --}}
        </div>
    </div>

    {{-- Keterangan Order --}}
    <div class="p-6 space-y-3 bg-white shadow rounded-xl">
        <p class="text-gray-700">
            <strong>Alamat Pengiriman:</strong><br>{{ $order->shipping_address }}
        </p>

        <div class="flex flex-col gap-4 mt-2 sm:flex-row sm:gap-12">
            <div class="flex items-center gap-2">
                <p class="font-medium">Status Pembayaran:</p>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    @if($order->payment_status === 'paid')
                    Sudah Dibayar
                    @elseif($order->payment_status === 'pending')
                    Belum Dibayar
                    @elseif($order->payment_status === 'canceled')
                    Dibatalkan
                    @endif
                </span>
            </div>
            <div class="flex items-center gap-2">
                <p class="font-medium">Status Order:</p>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    {{ $order->order_status === 'processing' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700' }}">
                    @if($order->order_status === 'pending')
                    Menunggu Pembayaran
                    @elseif($order->order_status === 'processing')
                    Diproses Admin
                    @elseif($order->order_status === 'shipped')
                    Sedang Dikirim
                    @elseif($order->order_status === 'delivered')
                    Sudah Diterima
                    @elseif($order->order_status === 'canceled')
                    Dibatalkan
                    @endif
                </span>
            </div>
        </div>
    </div>

    {{-- Daftar Item --}}
    <div class="p-6 bg-white shadow rounded-xl">
        <h3 class="mb-4 text-lg font-bold text-gray-800">Item Pesanan</h3>

        <div class="space-y-4">
            @foreach($order->orderItem as $item)
                <div class="flex items-center gap-4 pb-4 border-b">
                    <img src="{{ asset('storage/' . $item->laptop->laptop_images[0] ?? 'img/default.png') }}"
                         class="object-cover w-20 h-16 border rounded" alt="Thumbnail">

                    <div class="flex-1">
                        <p class="font-medium text-gray-800">
                            {{ $item->laptop->brand->brand_name ?? '-' }} {{ $item->laptop->model }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $item->quantity }} x Rp{{ number_format($item->price_per_item, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="font-semibold text-right text-blue-600">
                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-between pt-6 mt-6 text-lg font-bold text-gray-900 border-t">
            <span>Total Pembayaran</span>
            <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
