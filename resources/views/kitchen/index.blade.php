@extends('layouts.app')
@section('content')
<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Daftar Pesanan Dapur</h4>
            </div>
            <div class="row">
                @forelse ($orders as $order)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="card-title">
                                        {{-- Menampilkan Nomor Meja atau Nama Pelanggan (jika ada) --}}
                                        @if($order->table)
                                            {{ $order->table->name }}
                                        @else
                                            Pesanan #{{ substr($order->invoice, -4) }}
                                        @endif
                                    </div>
                                    <small>{{ $order->created_at->diffForHumans() }}</small>
                                </div>
                                @if($order->status == 'pending')
                                    <span class="badge badge-warning">Baru</span>
                                @elseif($order->status == 'dimasak')
                                    <span class="badge badge-info">Dimasak</span>
                                @endif
                            </div>
                            <div class="card-body">
                                {{-- PERBAIKAN: Menambahkan perulangan untuk menampilkan item pesanan --}}
                                <ul class="list-group list-group-flush">
                                    @foreach ($order->items as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $item->product->name_product }}</span>
                                            <span class="badge badge-primary badge-pill">{{ $item->qty }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-action">
                                <div class="btn-group btn-group-sm d-flex" role="group">
                                    @if($order->status == 'pending')
                                        <form action="{{ route('kitchen.status.update', $order->id) }}" method="POST" class="w-100">
                                            @csrf
                                            <input type="hidden" name="status" value="dimasak">
                                            <button type="submit" class="btn btn-info btn-block">Proses Masak</button>
                                        </form>
                                    @endif
                                    
                                    @if($order->status == 'dimasak')
                                        <form action="{{ route('kitchen.status.update', $order->id) }}" method="POST" class="w-100">
                                            @csrf
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="btn btn-success btn-block">Selesai</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('kitchen.status.update', $order->id) }}" method="POST" class="w-100">
                                        @csrf
                                        <input type="hidden" name="status" value="habis">
                                        <button type="submit" class="btn btn-danger btn-block">Stok Habis</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center mt-5">
                        <i class="fa fa-check-circle fa-4x text-success"></i>
                        <p class="text-muted mt-3">Tidak ada pesanan yang perlu disiapkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
