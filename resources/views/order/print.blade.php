<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk Pembayaran</title>
    <style>
        body, span, table {
            font-size: 12px;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #000;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div align="center">
        {{-- Jika ada logo, tampilkan. Jika tidak, tampilkan nama kafe --}}
        @if(isset($setting->images))
            <img src="{{ public_path('assets/img/setting/'.$setting->images) }}" style="width: 50%">
        @else
            <h3>{{ $setting->name ?? 'CAFFEE_IN' }}</h3>
        @endif
    </div>
    <br>
    <div align="center">
        <span>{{ $setting->name ?? 'CAFFEE_IN' }}</span><br>
        <span>{{ $setting->phone ?? 'Telepon Anda' }}</span><br>
        <span>{{ $setting->address ?? 'Alamat Anda' }}</span>
    </div>
    <hr style="border-style: dashed">
    <div>
        <table style="width: 100%">
            <tr>
                <td>No: {{ $order->invoice }}</td>
                <td class="text-right">{{ $order->created_at->format('d/m/Y') }}</td>
            </tr>
             <tr>
                <td>Kasir: {{ $order->user->name }}</td>
                <td class="text-right"></td>
            </tr>
        </table>
    </div>
    <hr style="border-style: dashed">
    <div>
        <table style="width: 100%">
            {{-- PERBAIKAN: Menggunakan relasi $order->items untuk menampilkan detail --}}
            @php
                $subtotal = 0;
                $totalDiskon = 0;
            @endphp
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->qty }}x {{ $item->product->name_product }}</td>
                <td class="text-right">@currency($item->price * $item->qty)</td>
            </tr>
            @php
                $subtotal += $item->price * $item->qty;
                // Asumsi diskon adalah nominal per produk
                $totalDiskon += ($item->product->discount ?? 0) * $item->qty;
            @endphp
            @endforeach
        </table>
    </div>
    <hr style="border-style: dashed">
    <div>
        <table style="width: 100%">
             @php
                $netSubtotal = $subtotal - $totalDiskon;
                $pajak = $tax ? ($netSubtotal * $tax->value / 100) : 0;
                $jumlah = $netSubtotal + $pajak;
            @endphp
            <tr>
                <td>Subtotal :</td>
                <td class="text-right">@currency($subtotal)</td>
            </tr>
            <tr>
                <td>Diskon :</td>
                <td class="text-right">@currency($totalDiskon)</td>
            </tr>
            <tr>
                <td>Pajak ({{ $tax->value ?? 0 }}%) :</td>
                <td class="text-right">@currency($pajak)</td>
            </tr>
        </table>
    </div>
    <hr style="border-style: dashed">
    <div>
        <table style="width: 100%">
            <tr>
                <td><strong>Total :</strong></td>
                <td class="text-right"><strong>@currency($jumlah)</strong></td>
            </tr>
        </table>
    <hr style="border-style: dashed">
    <br>
    <div align="center">
        <span>Terima Kasih - Silahkan datang lagi!</span>
    </div>
</body>
</html>
