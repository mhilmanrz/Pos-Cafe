@extends('layouts.app')
@section('content')

<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-secondary mr-3">
                                <i class="fa fa-box"></i>
                            </span>
                            <div>
                                <!-- PERBAIKAN: Menghapus fungsi count() karena $products sudah berisi angka -->
                                <h5 class="mb-1"><b><a href="#">{{ $products }}</a></b></h5>
                                <small class="text-muted">Produk</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-success mr-3">
                                <i class="fa fa-shopping-cart"></i>
                            </span>
                            <div>
                                <!-- PERBAIKAN: Menghapus fungsi count() karena $orders sudah berisi angka -->
                                <h5 class="mb-1"><b><a href="#">{{ $orders }}</a></b></h5>
                                <small class="text-muted">Order</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-danger mr-3">
                                <i class="fas fa-shopping-basket"></i>
                            </span>
                            <div>
                                <h5 class="mb-1"><b><a href="#">@currency($total)</a></b></h5>
                                <small class="text-muted">Penjualan hari ini</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-warning mr-3">
                                <i class="fas fa-cart-arrow-down"></i>
                            </span>
                            <div>
                                <h5 class="mb-1"><b><a href="#">{{ $carts }}</a></b></h5>
                                <small class="text-muted">Produk terjual hari ini</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Grafik penjualan</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="min-height: 375px">
                                <canvas id="statisticsChart"></canvas>
                            </div>
                            <div id="myChartLegend"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection

@push('scripts')

<script>

var ctx = document.getElementById('statisticsChart').getContext('2d');

var statisticsChart = new Chart(ctx, {
    type: 'line',
    data: {
labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [ {
            label: "Penjualan",
            borderColor: '#177dff',
            pointBackgroundColor: 'rgba(23, 125, 255, 0.6)',
            pointRadius: 0,
            backgroundColor: 'rgba(23, 125, 255, 0.4)',
            legendColor: '#177dff',
            fill: true,
            borderWidth: 2,
            // PERBAIKAN: Menggunakan variabel $chart_data dari HomeController
            // yang berisi data penjualan per bulan untuk tahun ini.
            data: @json($chart_data)
        }]
    },
    options : {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            display: false
        },
        tooltips: {
            bodySpacing: 4,
            mode:"nearest",
            intersect: 0,
            position:"nearest",
            xPadding:10,
            yPadding:10,
            caretPadding:10
        },
        layout:{
            padding:{left:5,right:5,top:15,bottom:15}
        },
        scales: {
            yAxes: [{
                ticks: {
                    fontStyle: "500",
                    beginAtZero: false,
                    maxTicksLimit: 5,
                    padding: 10
                },
                gridLines: {
                    drawTicks: false,
                    display: false
                }
            }],
            xAxes: [{
                gridLines: {
                    zeroLineColor: "transparent"
                },
                ticks: {
                    padding: 10,
                    fontStyle: "500"
                }
            }]
        },
        legendCallback: function(chart) {
            var text = [];
            text.push('<ul class="' + chart.id + '-legend html-legend">');
            for (var i = 0; i < chart.data.datasets.length; i++) {
                text.push('<li><span style="background-color:' + chart.data.datasets[i].legendColor + '"></span>');
                if (chart.data.datasets[i].label) {
                    text.push(chart.data.datasets[i].label);
                }
                text.push('</li>');
            }
            text.push('</ul>');
            return text.join('');
        }
    }
});
</script>

@endpush
