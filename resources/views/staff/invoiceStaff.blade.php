<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/imgs/theme/favicon.svg') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-header h1 {
            font-size: 36px;
        }

        .order-details {
            margin-bottom: 30px;
        }

        .order-details h4 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .order-details p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .item-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .item-table th, .item-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .payment-details {
            margin-bottom: 30px;
        }

        .payment-details h4 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .payment-details p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .shipping-address {
            margin-bottom: 30px;
        }

        .shipping-address h4 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .shipping-address p {
            font-size: 18px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Invoice</h1>
    </div>

    <div class="order-details">
        <h4>Informasi Pemesanan:</h4>
        <p><strong>ID pemesanan:</strong> {{ $order->order_id }}</p>
        <p><strong>Status Order:</strong>
            @php
$statusText = '';
switch ($order->status) {
    case 0:
        $statusText = 'Sedang Diproses';
        break;
    case 1:
        $statusText = 'Sedang Dikirim';
        break;
    case 2:
        $statusText = 'Sudah Diterima';
        break;
    case 3:
        $statusText = 'Dibatalkan';
        break;
    default:
        $statusText = 'Status Tidak Valid';
}
@endphp
{{ $statusText }}
</p>
        <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 2) }}</p>
        <p><strong>Nomer Resi:</strong> {{ $order->tracking_number }}</p>
        <p><strong>Catatan:</strong> {{ $order->notes }}</p>
    </div>

    <div class="item-table">
        <h4>Barang yang diBeli:</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $orderItem)
                    <tr>
                        <td>{{ $orderItem->product->name }}</td>
                        <td>{{ $orderItem->quantity }}</td>
                        <td>Rp {{ number_format($orderItem->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @foreach ($order->payments as $payment)
    <div class="payment-details">
        <p><strong>Status Pembayaran:</strong>
            @php
$statusText = '';
switch ($payment->status_pembayaran) {
    case 0:
        $statusText = 'Belum Dibayar';
        break;
    case 1:
        $statusText = 'Sudah Dibayar';
        break;
    case 2:
        $statusText = 'Dibatalkan';
        break;
    default:
        $statusText = 'Status Tidak Valid';
}
@endphp
{{ $statusText }}
</p>
    </div>
@endforeach

@foreach ($order->pengirimens as $pengirimen)

    <div class="shipping-address">
        <h4>Alamat pengiriman:</h4>
        <p><strong>Alamat:</strong> {{ $pengirimen->address }}</p>
        <p><strong>Provinsi:</strong> {{ $pengirimen->province }}</p>
        <p><strong>Kota:</strong> {{ $pengirimen->city }}</p>
        <p><strong>Kode Pos:</strong> {{ $pengirimen->postal_code }}</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endforeach
</body>
</html>
