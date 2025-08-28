@extends('layouts.app')
@section('title','Halaman Penjualan')
@section('content')

{{-- Style untuk tombol kuantitas --}}
<style>
.quantity{display:inline-block}.quantity .input-text.qty{width:50px;height:35px;padding:0 5px;text-align:center;background-color:transparent;border:1px solid #efefef}.quantity.buttons_added{text-align:left;position:relative;white-space:nowrap;vertical-align:top}.quantity.buttons_added input{display:inline-block;margin:0;vertical-align:top;box-shadow:none}.quantity.buttons_added .minus,.quantity.buttons_added .plus{padding:7px 10px 8px;height:35px;background-color:#fff;border:1px solid #efefef;cursor:pointer}.quantity.buttons_added .minus{border-right:0}.quantity.buttons_added .plus{border-left:0}.quantity.buttons_added .minus:hover,.quantity.buttons_added .plus:hover{background:#eee}.quantity input::-webkit-outer-spin-button,.quantity input::-webkit-inner-spin-button{-webkit-appearance:none;-moz-appearance:none;margin:0}.quantity.buttons_added .minus:focus,.quantity.buttons_added .plus:focus{outline:none}
</style>

<div class="main-panel">
    <div class="container">
       <div class="page-inner">
          <div class="row">
             <div class="col-md-8">
                <div class="card">
                   <div class="card-header">
                      <div class="card-head-row">
                         <div class="card-title">DAFTAR MENU</div>
                      </div>
                   </div>
                   <div class="card-body">
                      <div class="row">
                         @foreach($products as $product)
                         <div class="col-md-4 col-6">
                            <div class="card">
                               <div class="p-2">
                                  <img class="card-img-top rounded" src="{{ asset('assets/img/product/'.$product->image) }}" alt="Product Image" style="height: 150px; object-fit: cover;">
                               </div>
                               <div class="card-body pt-2">
                                  <h4 class="mb-1 fw-bold">{{ $product->name_product }}</h4>
                                  @if($product->discount != 0)
                                  <p class="text-muted small mb-2">@currency($product->price - $product->discount) <sup style="text-decoration: line-through;">@currency($product->price)</sup></p>
                                  @else
                                  <p class="text-muted small mb-2">@currency($product->price)</p>
                                  @endif
                                  <button type="button" data-id="{{ $product->id }}" class="btn btn-primary btn-sm btn-order" style="width: 100%;" data-toggle="modal" data-target="#exampleModal">Pesan</button>
                               </div>
                            </div>
                         </div>
                         @endforeach
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-md-4">
                {{-- Side Kanan: Pesanan --}}
                <div class="card">
                   <div class="card-header">
                        <h5 class="card-title">PESANAN</h5>
                   </div>
                   <div class="card-body">
                      <div class="card-list">
                         @php
                            $subtotal = 0;
                            $totalDiskon = 0;
                         @endphp
                         @forelse($carts as $cart)
                         <div class="item-list">
                            <div class="avatar">
                               <img src="{{ asset('assets/img/product/'. $cart->product->image) }}" alt="..." class="avatar-img rounded-circle">
                            </div>
                            <div class="info-user ml-3">
                               <div class="username">{{ $cart->product->name_product }} ({{ $cart->qty }})</div>
                               <div class="status">@currency($cart->product->price)</div>
                            </div>
                            <button class="btn btn-icon btn-danger btn-round btn-xs delete-cart" data-id="{{ $cart->id }}">
                               <i class="fa fa-trash"></i>
                            </button>
                         </div>
                         @if($cart->product->discount != 0)
                         <div style="font-size: 11px; margin-left: 55px;">
                            Diskon: @currency($cart->product->discount * $cart->qty)
                         </div>
                         @endif
                         @php
                            $subtotal += $cart->product->price * $cart->qty;
                            $totalDiskon += $cart->product->discount * $cart->qty;
                         @endphp
                         @empty
                         <p class="text-center text-muted">Keranjang kosong</p>
                         @endforelse
                      </div>
                      <hr>
                      @php
                         $netSubtotal = $subtotal - $totalDiskon;
                         $nilaiPajak = $tax ? ($netSubtotal * $tax->value / 100) : 0;
                         $totalAkhir = $netSubtotal + $nilaiPajak;
                      @endphp
                      <input type="hidden" id="total_hidden" value="{{ $totalAkhir }}">
                      <div class="row">
                         <div class="col-md-6 col-6"><h5>Subtotal</h5></div>
                         <div class="col-md-6 col-6 text-right"><h5>@currency($subtotal)</h5></div>
                      </div>
                      <div class="row mt-2">
                         <div class="col-md-6 col-6"><h5>Diskon</h5></div>
                         <div class="col-md-6 col-6 text-right"><h5>@currency($totalDiskon)</h5></div>
                      </div>
                      <div class="row mt-2">
                         <div class="col-md-6 col-6"><h5>Pajak ({{ $tax->value ?? 0 }}%)</h5></div>
                         <div class="col-md-6 col-6 text-right"><h5>@currency($nilaiPajak)</h5></div>
                      </div>
                      <hr>
                      <div class="row">
                         <div class="col-md-6 col-6"><h5>Total</h5></div>
                         <div class="col-md-6 col-6 text-right"><h5>@currency($totalAkhir)</h5></div>
                      </div>
                   </div>
                </div>
                {{-- Side Kanan: Pembayaran --}}
                <div class="card">
                   <div class="card-header">
                        <h5 class="card-title">PEMBAYARAN</h5>
                   </div>
                   <div class="card-body">
                      {!! Form::open(['id' => 'payment-form']) !!}
                      <div class="form-group">
                         <label for="table_id">Nomor Meja</label>
                         <select class="form-control" id="table_id" name="table_id">
                            <option value="">Lainnya (Take Away)</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">{{ $table->name }}</option>
                            @endforeach
                         </select>
                      </div>
                      <div class="form-group">
                         <label>Jenis pembayaran</label>
                         <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="payment_method" value="tunai" class="selectgroup-input" checked>
                                <span class="selectgroup-button">TUNAI</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="payment_method" value="cashless" class="selectgroup-input">
                                <span class="selectgroup-button">NON TUNAI</span>
                            </label>
                         </div>
                      </div>
                      <div class="form-group" id="card-payment-method" style="display: none;">
                          <label for="card_id">Pembayaran via</label>
                          {{ Form::select('card_id', $card, null, ['class'=>'form-control', 'id' => 'card_id_select', 'placeholder' => 'Pilih Jenis Kartu...']) }}
                      </div>
                      {!! Form::close() !!}
                   </div>
                   <div class="card-footer">
                      <button type="button" class="btn btn-success" id="btn-pay" style="width: 100%"><i class="fas fa-shopping-cart"></i> Bayar sekarang</button>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-6">
                  <img src="" id="image-detail" alt="..." class="img-fluid rounded">
               </div>
               <div class="col-md-6">
                  <input type="hidden" id="id-product">
                  <h3 class="fw-bold" id="title-detail"></h3>
                  <p class="mb-1"><span class="badge badge-info">Sisa Stok: <span id="title-stock">0</span></span></p>
                  <div style="padding: 0px 19px;">
                     <h5 class="mb-1 mt-4">Deskripsi : </h5>
                     <p class="text-muted small mb-2" id="title-description"></p>
                     <h5 class="mb-1 mt-4">Qty : </h5>
                     <div class="quantity buttons_added">
                        <input type="button" value="-" class="minus">
                        <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">
                        <input type="button" value="+" class="plus">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-sm btn-add-cart">Tambah</button>
         </div>
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Fungsi untuk mengambil detail produk dan menampilkannya di modal
        $('.btn-order').click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route('order.detail') }}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(data) {
                    $('#id-product').val(data.id);
                    $('#title-detail').html(data.name_product);
                    $('#title-stock').text(data.stock);
                    $('#title-description').html(data.description);
                    $('#image-detail').attr('src', '{{ asset('assets/img/product/') }}/' + data.image);
                }
            });
        });

        // Fungsi untuk menambahkan item ke keranjang
        $('.btn-add-cart').click(function() {
            var id = $('#id-product').val();
            var qty = $('.qty').val();
            $.ajax({
                url: '{{ route('cart.store') }}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: id,
                    qty: qty,
                },
                success: function(data) {
                    swal("Success", "Berhasil ditambahkan ke keranjang!", "success");
                    setTimeout(() => { location.reload() }, 1000);
                }
            });
        });

        // Fungsi untuk menghapus item dari keranjang
        $('.delete-cart').click(function() {
            var id = $(this).data('id');
            swal({
                title: 'Apakah kamu yakin?',
                text: "Item ini akan dihapus dari keranjang.",
                type: 'warning',
                buttons: {
                    confirm: { text: 'Ya, hapus!', className: 'btn btn-success' },
                    cancel: { visible: true, className: 'btn btn-danger' }
                }
            }).then((Delete) => {
                if (Delete) {
                    $.ajax({
                        url: '{{ route('cart.delete') }}',
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(data) {
                            swal("Success", "Item berhasil dihapus.", "success");
                            setTimeout(() => { location.reload() }, 1000);
                        }
                    });
                } else {
                    swal.close();
                }
            });
        });

        // Menampilkan atau menyembunyikan pilihan kartu berdasarkan metode pembayaran
        $('input[name="payment_method"]').change(function() {
            if ($(this).val() == 'cashless') {
                $('#card-payment-method').slideDown();
            } else {
                $('#card-payment-method').slideUp();
            }
        });

        // PERBAIKAN: Fungsi untuk memproses pembayaran
        $('#btn-pay').click(function() {
            var paymentMethod = $('input[name="payment_method"]:checked').val();
            var tableId = $('#table_id').val();
            var cardId = (paymentMethod === 'cashless') ? $('#card_id_select').val() : null;

            if (paymentMethod === 'cashless' && !cardId) {
                swal("Error", "Silakan pilih jenis kartu untuk pembayaran non-tunai.", "error");
                return;
            }

            var ajaxData = {
                _token: "{{ csrf_token() }}",
                total: $('#total_hidden').val(),
                payment: paymentMethod,
                table_id: tableId, // Mengirim table_id yang benar
                card_id: cardId
            };

            $.ajax({
                url: '{{ route('order.store') }}',
                method: 'POST',
                data: ajaxData,
                success: function(data) {
                    if (data.error) {
                         swal("Error", data.error, "error");
                         return;
                    }
                    swal("Success", "Pesanan berhasil dibuat!", "success");
                    window.open('/order/' + data.invoice + '/cetak', '_blank');
                    setTimeout(() => { location.reload() }, 1500);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    swal("Error", "Terjadi kesalahan saat memproses pesanan.", "error");
                }
            });
        });

    });

    // Skrip untuk tombol +/- kuantitas
    function wcqib_refresh_quantity_increments(){jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function(a,b){var c=jQuery(b);c.addClass("buttons_added"),c.children().first().before('<input type="button" value="-" class="minus" />'),c.children().last().after('<input type="button" value="+" class="plus" />')})}
    String.prototype.getDecimals||(String.prototype.getDecimals=function(){var a=this,b=(""+a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);return b?Math.max(0,(b[1]?b[1].length:0)-(b[2]?+b[2]:0)):0}),jQuery(document).ready(function(){wcqib_refresh_quantity_increments()}),jQuery(document).on("updated_wc_div",function(){wcqib_refresh_quantity_increments()}),jQuery(document).on("click",".plus, .minus",function(){var a=jQuery(this).closest(".quantity").find(".qty"),b=parseFloat(a.val()),c=parseFloat(a.attr("max")),d=parseFloat(a.attr("min")),e=a.attr("step");b&&""!==b&&"NaN"!==b||(b=0),""!==c&&"NaN"!==c||(c=""),""!==d&&"NaN"!==d||(d=0),"any"!==e&&""!==e&&void 0!==e&&"NaN"!==parseFloat(e)||(e=1),jQuery(this).is(".plus")?c&&b>=c?a.val(c):a.val((b+parseFloat(e)).toFixed(e.getDecimals())):d&&b<=d?a.val(d):b>0&&a.val((b-parseFloat(e)).toFixed(e.getDecimals())),a.trigger("change")});
</script>
@endpush
