@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Keranjang Belanja untuk {{ Session::get('table_name', 'Meja Anda') }}</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th class="text-center">Kuantitas</th>
                                            <th class="text-right">Harga</th>
                                            <th class="text-right">Subtotal</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0 @endphp
                                        @if(!empty($cart))
                                            @foreach($cart as $id => $details)
                                                @php $total += $details['price'] * $details['quantity'] @endphp
                                                <tr data-id="{{ $id }}">
                                                    <td>{{ $details['name'] }}</td>
                                                    <td class="text-center">
                                                        <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity-update" style="width: 70px; display: inline-block;">
                                                    </td>
                                                    <td class="text-right">@currency($details['price'])</td>
                                                    <td class="text-right">@currency($details['price'] * $details['quantity'])</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger btn-sm remove-from-cart">Hapus</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">Keranjang Anda kosong.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('customer.menu.table', ['table' => Session::get('table_id')]) }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Lanjut Belanja</a>
                                </div>
                                <div class="col-md-6 text-right">
                                    @php
                                        $pajak = $tax ? ($total * $tax->value / 100) : 0;
                                        $totalAkhir = $total + $pajak;
                                    @endphp
                                    <h5>Subtotal: @currency($total)</h5>
                                    <h5>Pajak ({{ $tax->value ?? 0 }}%): @currency($pajak)</h5>
                                    <h4><strong>Total: @currency($totalAkhir)</strong></h4>
                                    <form action="{{ route('customer.order.place', ['table' => Session::get('table_id')]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-lg">Buat Pesanan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $(".quantity-update").change(function (e) {
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: '{{ route('customer.cart.update', ['table' => Session::get('table_id')]) }}',
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.parents("tr").attr("data-id"), 
                quantity: ele.val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        if(confirm("Apakah Anda yakin ingin menghapus item ini?")) {
            $.ajax({
                url: '{{ route('customer.cart.remove', ['table' => Session::get('table_id')]) }}',
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
});
</script>
@endpush
