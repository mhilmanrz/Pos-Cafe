@extends('layouts.app')
@section('title','Laporan Penjualan')
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
                            <h5 class="card-title">Report penjualan</h5>
                         </div>
                      </div>
                   </div>
                   <div class="card-body">
                      <div class="table-responsive">
                         <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                               <tr>
                                  <th style="width: 5%">No</th>
                                  {{-- PERBAIKAN: Menambahkan header kolom Tanggal --}}
                                  <th>Tanggal</th>
                                  <th>Invoice</th>
                                  <th>Kasir</th>
                                  <th>Sumber Pesanan (Meja)</th>
                                  <th>Jenis pembayaran</th>
                                  <th>Total</th>
                                  <th style="width: 10%" class="text-center">Action</th>
                               </tr>
                            </thead>
                            <tbody>
                               @foreach($orders as $order)
                               <tr>
                                  <td>{{ $loop->iteration }}</td>
                                  {{-- PERBAIKAN: Menampilkan data tanggal transaksi --}}
                                  <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                  <td>{{ $order->invoice }}</td>
                                  {{-- PERBAIKAN: Mengganti N/A menjadi Pelanggan (QR) --}}
                                  <td>{{ $order->user ? $order->user->name : 'Pelanggan (QR)' }}</td>
                                  <td>{{ $order->table->name ?? ($order->name_customer ?: 'Take Away / Lainnya') }}</td>
                                  <td>{{ $order->payment }}</td>
                                  <td>@currency($order->total)</td>
                                  <td>
                                     <div class="form-button-action">
                                        <a href="{{ route('order.cetak',[$order->invoice]) }}" data-toggle="tooltip" title="Cetak Invoice" class="btn btn-link btn-primary btn-lg">
                                           <i class="fa fa-print"></i>
                                        </a>
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
