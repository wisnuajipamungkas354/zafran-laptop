<div class="max-w-6xl px-4 py-10 mx-auto">
    <h2 class="mb-8 text-3xl font-bold text-gray-800">Riwayat Transaksi</h2>

    @if($orders->isEmpty())
        <div class="p-6 text-center text-gray-500 bg-white rounded-lg shadow-sm">
            Belum ada transaksi yang tercatat.
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
            <div class="flex p-6 transition bg-white border shadow-sm rounded-xl hover:shadow-md">
                    <div class="flex flex-col items-start justify-between md:flex-row md:items-center">
                        <div>
                            <a href="{{ route('transaksi.detail', $order->id) }}"
                               class="text-lg font-semibold text-blue-600 hover:underline">
                                Order #{{ $order->id }}
                            </a>
                            <p class="text-sm text-gray-500">
                                {{ $order->created_at->format('d M Y H:i') }}
                            </p>
                            <p class="mt-1 text-gray-700">
                                Total: <span class="font-semibold text-gray-900">
                                    Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                {{ $order->order_status === 'processing' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700' }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
