<div class="w-full px-4 py-10 mx-auto">
    <h2 class="mb-8 text-3xl font-bold text-gray-800">Riwayat Transaksi</h2>

    @if($orders->isEmpty())
        <div class="p-6 text-center text-gray-500 bg-white rounded-lg shadow-sm">
            Belum ada transaksi yang tercatat.
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="p-6 transition bg-white border shadow-sm rounded-xl hover:shadow-md">
                    <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center">

                        {{-- Kiri: Info Order --}}
                        <div class="flex-1">
                            <div class="mb-2">
                                <a href="{{ route('transaksi.detail', $order->order_number) }}"
                                   class="text-lg font-semibold text-blue-600 hover:underline">
                                    Order #{{ $order->order_number }}
                                </a>
                                <p class="text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </p>
                            </div>

                            <p class="text-gray-700">
                                Total: <strong class="text-gray-900">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                            </p>

                            {{-- Ringkasan item --}}
                            <div class="mt-2 space-y-1">
                                @foreach($order->orderItem as $item)
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('storage/' . $item->laptop->laptop_images[0] ?? 'img/default.png') }}"
                                            alt="Gambar" class="object-cover w-10 h-10 border rounded" />
                                        <p class="text-sm text-gray-700">
                                            {{ $item->laptop->brand->brand_name ?? '-' }} {{ $item->laptop->model }}
                                            <span class="text-xs text-gray-500">({{ $item->quantity }}x)</span>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Kanan: Status & Aksi --}}
                        <div class="flex flex-col items-start gap-2 md:items-end md:justify-between">

                            {{-- Klaim Garansi --}}
                            @if(!$order->delivery || !$order->delivery->delivery_date)
                            {{-- Status --}}
                            <div class="flex flex-wrap gap-2">
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
                            {{-- @elseif($order->isReturnable())
                                <a href="{{ route('retur.form', $order->id) }}" wire:navigate
                                   class="inline-block px-4 py-2 text-sm text-white bg-red-600 rounded-xl hover:bg-red-700">
                                    Klaim Garansi
                                </a> --}}
                            @else
                                <p class="text-sm italic text-gray-500">
                                   Transaksi Selesai
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
