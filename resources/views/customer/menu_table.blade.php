@extends('layouts.app')
@section('title', 'Menu untuk ' . $table->name)

@section('content')
<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Menu untuk {{ $table->name }}</h4>
                
                {{-- Tombol Keranjang sekarang mengarah ke halaman keranjang --}}
                <a href="{{ route('customer.cart.show', ['table' => $table->id]) }}" class="btn btn-primary ml-auto">
                    <i class="fa fa-shopping-cart"></i> 
                    Keranjang <span class="badge badge-light" id="cart-count">{{ count((array) session('customer_cart')) }}</span>
                </a>
            </div>
            <div class="row">
                @forelse($products as $product)
                <div class="col-md-3 col-6">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('assets/img/product/'.$product->image) }}" alt="Gambar Produk" style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name_product }}</h5>
                            <p class="card-text">@currency($product->price)</p>
                            {{-- Tombol Tambah dengan atribut data-id untuk JavaScript --}}
                            <button type="button" class="btn btn-success btn-block btn-add-to-cart" data-id="{{ $product->id }}">Tambah</button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-center text-muted">Belum ada produk yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.btn-add-to-cart').click(function(e) {
        e.preventDefault();
        var productId = $(this).data('id');

        $.ajax({
            url: "{{ route('customer.cart.add', ['table' => $table->id]) }}",
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}', 
                product_id: productId
            },
            success: function (response) {
                // Update jumlah item di tombol keranjang
                var currentCount = parseInt($('#cart-count').text());
                $('#cart-count').text(currentCount + 1);
                
                // Tampilkan notifikasi
                swal({
                    title: "Berhasil!",
                    text: "Produk telah ditambahkan ke keranjang.",
                    icon: "success",
                    buttons: {
                        confirm: {
                            className : 'btn btn-success'
                        }
                    },
                    timer: 1500
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
                swal("Error", "Gagal menambahkan produk.", "error");
            }
        });
    });
});
</script>
@endpush
