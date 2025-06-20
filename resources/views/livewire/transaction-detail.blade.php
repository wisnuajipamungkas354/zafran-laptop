<div class="max-w-5xl px-4 py-10 mx-auto">
    <div class="flex items-center gap-3">
        <h2 class="mb-8 text-3xl font-bold text-gray-800">Detail Transaksi #{{ $order->id }}</h2>
        <a href="{{ route('transaksi.invoice', $order->id) }}"
            target="_blank"
            class="inline-block px-4 py-2 mb-6 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-xl">
             Download Invoice PDF
        </a>
        
        @if($order->isReturnable())
            <a href="{{ route('retur.form', $order->id) }}"
            class="inline-block px-4 py-2 mt-4 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                Ajukan Retur / Klaim Garansi
            </a>
        @else
            <p class="mt-4 text-sm italic text-gray-500">Masa klaim garansi (14 hari) telah berakhir.</p>
        @endif

    </div>
     

    {{-- Informasi Order --}}
    <div class="p-6 mb-6 space-y-2 bg-white shadow rounded-xl">
        <p class="text-gray-700"><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
        <span class="text-gray-700"><strong>Alamat Pengiriman:</strong> <br>
             {{ $order->shipping_address }}
        </span>

        <div class="flex flex-col gap-2 mt-3">
            <span class="flex justify-between">
                <p><strong>Status Pembayaran :</strong></p>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    
                    {{ ucfirst($order->payment_status) }}
                </span>
            </span>
            <span class="flex justify-between">
                <p><strong>Status Order :</strong></p>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    {{ $order->order_status === 'processing' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700' }}">
                    {{ ucfirst($order->order_status) }}
                </span>
            </span>
        </div>
    </div>

    {{-- Daftar Item --}}
    <div class="p-6 bg-white shadow rounded-xl">
        <h3 class="mb-4 text-lg font-bold text-gray-800">Item Pesanan</h3>

        <div class="divide-y">
            @foreach($order->orderItem as $item)
                <div class="flex items-center gap-4 py-4 border-b">
                    <img src="{{ asset('storage/' . $item->laptop->laptop_images[0] ?? 'img/default.png') }}"
                        class="object-cover w-20 h-16 border rounded" alt="Thumbnail">

                    <div class="flex-1">
                        <p class="font-semibold text-gray-800 uppercase">
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

        <div class="flex items-center justify-between pt-4 mt-6 text-lg font-bold text-gray-900 border-t">
            <span>Total</span>
            <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
