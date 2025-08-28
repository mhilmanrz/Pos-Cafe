<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman laporan penjualan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // PERBAIKAN: Menggunakan Eager Loading dengan `with()`
        // Ini akan mengambil data pesanan beserta relasi 'user' (kasir) dan 'table' (meja)
        // dalam satu query yang efisien untuk mencegah N+1 problem.
        $data['orders'] = Order::with(['user', 'table'])
                                ->orderBy('created_at', 'desc') // Mengurutkan dari yang terbaru
                                ->get();
                                
        return view('report.index', $data);
    }
}
