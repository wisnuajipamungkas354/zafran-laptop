<div class="max-w-2xl py-10 mx-auto">
    <h2 class="mb-4 text-xl font-bold">Pembayaran untuk Order #{{ $order->id }}</h2>
    <p>Total yang harus dibayar: <strong>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>

    <div id="snap-container" class="mt-6"></div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    window.onload = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                window.location.href = "/payment-success?order_id={{ $order->id }}";
            },
            onPending: function(result){
                console.log("pending", result);
            },
            onError: function(result){
                alert("Pembayaran gagal!");
            }
        });
    };
</script>
