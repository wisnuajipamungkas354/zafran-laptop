<!DOCTYPE html>
<html>
<head>
    <title>Laporan Order</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>Laporan Data Orders</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Order Number</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status Pembayaran</th>
                <th>Status Order</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ $order->customer->first_name ?? '-' }}</td>
                <td>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td>
                  @php
                      $paymentStatus = [
                          'pending' => 'Belum Dibayar',
                          'paid' => 'Dibayar',
                          'canceled' => 'Dibatalkan',
                      ];
                  @endphp
                  {{ $paymentStatus[$order->payment_status] ?? '-' }}
              </td>
              <td>
                  @php
                      $orderStatus = [
                          'pending' => 'Menunggu Pembayaran',
                          'processing' => 'Diproses Admin',
                          'shipped' => 'Sedang Dikirim',
                          'delivered' => 'Sudah Diterima',
                          'canceled' => 'Dibatalkan',
                      ];
                  @endphp
                  {{ $orderStatus[$order->order_status] ?? '-' }}
              </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
