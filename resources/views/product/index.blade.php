@extends('layouts.app')
@section('title','Manage Product')
@section('content')

<div class="main-panel">
    <div class="container">
       <div class="page-inner">
          <div class="row">
             <div class="col-md-12">
                <div class="card">
                   <div class="card-header">
                      <div class="row">
                         <div class="col-md-6">
                            <h5 class="card-title">Data Produk</h5>
                         </div>
                         <div class="col-md-6 text-right">
                            <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Tambah produk
                            </a>
                         </div>
                      </div>
                   </div>
                   <div class="card-body">
                      <div class="table-responsive">
                         <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                               <tr>
                                  <th style="width: 5%">No</th>
                                  <th style="width: 25%">Nama produk</th>
                                  <th style="width: 15%">Kategori</th>
                                  <th style="width: 15%">Harga</th>
                                  {{-- PERBAIKAN: Menambahkan kolom Sisa Stok --}}
                                  <th style="width: 10%">Sisa Stok</th>
                                  <th style="width: 15%">Diskon</th>
                                  <th style="width: 10%" class="text-center">Action</th>
                               </tr>
                            </thead>
                            <tbody>
                               @foreach($products as $product)
                               <tr>
                                  <td>{{ $loop->iteration }}</td>
                                  <td>{{ $product->name_product}}</td>
                                  <td>{{ $product->category->name_category}}</td>
                                  <td>@currency($product->price)</td>
                                  {{-- PERBAIKAN: Menampilkan data stok --}}
                                  <td>{{ $product->stock }}</td>
                                  <td>@currency($product->discount)</td>
                                  <td>
                                     <div class="form-button-action">
                                        <a href="{{ route('product.edit',[$product->id]) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lsm" data-original-title="Edit">
                                           <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-link btn-danger delete" data-id="{{ $product->id }}">
                                           <i class="fa fa-times"></i>
                                        </button>
                                     </div>
                                  </td>
                               </tr>
                               @endforeach
                            </tbody>
                         </table>
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
    $('.delete').click(function(e) {
        var id = $(this).data('id'); 
        swal({
           title: 'Apakah kamu yakin ?',
           text: "Produk akan terhapus secara permanen !",
           type: 'warning',
           buttons:{
              confirm: {
                 text : 'Ya, saya yakin!',
                 className : 'btn btn-success'
              },
              cancel: {
                 visible: true,
                 className: 'btn btn-danger'
              }
           }
        }).then((Delete) => {
           if (Delete) {
              $.ajax({
                 url: '{{ route('product.delete') }}',
                 method: 'post',
                 cache: false,
                 data: {
                    "_token": "{{ csrf_token() }}",
                    "id" :id
                 },
                 success: function(data){
                    swal("Good job!", "You clicked the button!", {
                       icon : "success",
                       buttons: { 
                          confirm: {
                             className : 'btn btn-success'
                          }
                       },
                    });
                    location.reload();
                 }
              });
           } else {
              swal.close();
           }
        });
   });
});
</script>
@endpush