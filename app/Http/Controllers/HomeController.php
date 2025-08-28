<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Ringkasan dashboard
        $data['products'] = Product::count();
        $data['orders']   = Order::count();
        $data['total']    = Order::whereDate('created_at', today())->sum('total');
        $data['carts']    = Cart::whereDate('created_at', today())->sum('qty');

        // Grafik penjualan per bulan
        $sales_data = Order::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('SUM(total) as total_penjualan')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        // Siapkan array kosong untuk 12 bulan
        $chart_data = array_fill(0, 12, 0);

        // Isi data penjualan berdasarkan bulan
        foreach ($sales_data as $sale) {
            $index = (int)$sale->bulan - 1; // array mulai dari 0
            $chart_data[$index] = $sale->total_penjualan;
        }

        $data['chart_data'] = $chart_data;

        return view('welcome', $data);
    }
}
