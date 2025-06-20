<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 24px;
            border: 1px solid #eee;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 100px;
        }
        .heading {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        .info-table, .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .info-table td {
            padding: 6px 4px;
        }
        .items-table th {
            background-color: #f5f5f5;
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .items-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .total {
            text-align: right;
            padding-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 11px;
            color: #555;
            line-height: 1.6;
        }
        .footer hr {
            border: none;
            border-top: 1px dashed #ccc;
            margin: 10px 0;
        }

    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header" style="text-align: center; margin-bottom: 20px;">
          <img src="{{ public_path('img/logo.png') }}" width="50" style="margin-bottom: 10px;"><br>
          <h2 style="margin: 0;">Zafran Laptop</h2>
      
          <p style="font-size: 11px; margin: 2px 0;">
              Jln Rawa Bunder 16. Padurenan, Mustikajaya, Bekasi Timur, Kabupaten Bekasi - Jawa Barat
          </p>
          <p style="font-size: 11px; margin: 0;">
              WA: +62 811-912-127 • Email: rumahzafran@gmail.com
          </p>
      
          <hr style="margin-top: 12px; border-top: 1px solid #ddd;">
          <p style="margin-top: 6px; font-weight: bold;">INVOICE PEMBELIAN #{{ $order->id }}</p>
        </div>
    

        {{-- Info Order --}}
        <table class="info-table">
            <tr>
                <td><strong>No. Invoice:</strong> #{{ $order->id }}</td>
                <td><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Status:</strong> {{ ucfirst($order->payment_status) }}</td>
                <td><strong>Pengiriman:</strong> {{ $order->shipping_address }}</td>
            </tr>
        </table>

        {{-- Items --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItem as $item)
                    <tr>
                        <td>{{ $item->laptop->brand->brand_name ?? '-' }} {{ $item->laptop->model }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp{{ number_format($item->price_per_item, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Total --}}
        <p class="total">
            Total Pembayaran: Rp{{ number_format($order->total_amount, 0, ',', '.') }}
        </p>

        <div class="footer">
          <hr style="margin: 16px 0; border-top: 1px dashed #ccc;">
      
          <p style="font-size: 11px; text-align: left; line-height: 1.6;">
              <strong>Ketentuan Garansi Toko:</strong><br>
              - Garansi toko dapat diklaim selama <strong>14 hari</strong> terhitung sejak laptop diterima oleh pelanggan.<br>
              - Garansi tidak berlaku jika terjadi <em>human error</em> seperti tertindih, terkena air, terjatuh, dan sejenisnya.<br>
              - Garansi <strong>tidak dapat dikembalikan berupa uang</strong>, hanya berlaku untuk <strong>tukar unit</strong> atau <strong>perbaikan part</strong>.
          </p>
      
          <p style="text-align: center; font-size: 10px; margin-top: 30px; color: #777;">
              Invoice ini dicetak secara otomatis dan sah tanpa tanda tangan.
          </p>
      </div>         
    </div>
</body>
</html>
