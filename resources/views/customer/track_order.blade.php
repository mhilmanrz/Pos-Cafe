@extends('layouts.app')
@section('title', 'Lacak Pesanan')
@section('content')
<div class="main-panel">
    <div class="container" style="margin-top: 40px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <h3>Pesanan Anda #{{ $order->invoice }}</h3>
                        <p class="lead">Total Tagihan: <strong class="text-primary">@currency($order->total)</strong></p>
                        <hr>

                        {{-- Status Pesanan --}}
                        <div class="mt-4">
                            <h4>Status Pesanan</h4>
                            <div class="progress" style="height: 25px; font-size: 1rem;">
                                <div id="order-status-bar" class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: 33%;">Diterima</div>
                            </div>
                            <p class="mt-2 text-muted" id="status-text">Pesanan Anda telah kami terima dan akan segera diproses.</p>
                        </div>

                        <hr>

                        {{-- Detail Pembayaran QRIS --}}
                        <div class="mt-4">
                            <p>Silakan pindai QRIS di bawah ini untuk membayar:</p>
                            @if($setting && $setting->qris_image)
                                <img src="{{ asset('assets/img/setting/' . $setting->qris_image) }}" class="img-fluid" style="max-width: 250px; border: 1px solid #ddd; padding: 10px;">
                            @else
                                <p class="text-danger">Gambar QRIS belum di-upload oleh Admin.</p>
                            @endif
                            <div class="alert alert-info mt-4">
                                <strong>PENTING:</strong> Setelah pembayaran berhasil, harap tunjukkan bukti bayar kepada kasir untuk konfirmasi.
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
        function checkStatus() {
            $.ajax({
                url: "{{ route('customer.order.status', $order->invoice) }}",
                method: 'GET',
                success: function(response) {
                    var statusBar = $('#order-status-bar');
                    var statusText = $('#status-text');
                    var status = response.status;

                    statusBar.removeClass('progress-bar-animated'); // Hentikan animasi setelah update pertama

                    if (status === 'pending') {
                        statusBar.css('width', '33%').removeClass('bg-info bg-success').addClass('bg-warning').text('Diterima');
                        statusText.text('Pesanan Anda telah kami terima dan akan segera diproses.');
                    } else if (status === 'dimasak') {
                        statusBar.css('width', '66%').removeClass('bg-warning bg-success').addClass('bg-info').text('Diproses');
                        statusText.text('Pesanan Anda sedang disiapkan oleh tim dapur kami.');
                    } else if (status === 'selesai') {
                        statusBar.css('width', '100%').removeClass('bg-warning bg-info').addClass('bg-success').text('Siap Disajikan');
                        statusText.text('Pesanan Anda sudah siap! Silakan ambil di konter atau tunggu diantar ke meja Anda.');
                        clearInterval(statusInterval); // Hentikan pengecekan jika sudah selesai
                    } else if (status === 'habis') {
                        statusBar.css('width', '100%').removeClass('bg-warning bg-info').addClass('bg-danger').text('Dibatalkan');
                        statusText.text('Mohon maaf, salah satu item pesanan Anda habis. Silakan hubungi kasir.');
                        clearInterval(statusInterval); // Hentikan pengecekan
                    }
                }
            });
        }

        // Cek status setiap 5 detik
        var statusInterval = setInterval(checkStatus, 5000);
        // Jalankan pertama kali saat halaman dimuat
        checkStatus();
    });
</script>
@endpush