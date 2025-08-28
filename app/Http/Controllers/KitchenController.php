<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class KitchenController extends Controller
{
    /**
     * Menampilkan halaman utama dapur dengan daftar pesanan aktif.
     */
    public function index()
    {
        // Ambil semua order yang statusnya 'pending' (baru masuk) atau 'dimasak' (sedang diproses)
        $data['orders'] = Order::whereIn('status', ['pending', 'dimasak'])
                                ->with('items.product', 'table')
                                ->orderBy('created_at', 'asc')
                                ->get();

        return view('kitchen.index', $data);
    }

    /**
     * Memperbarui status pesanan.
     */
    public function updateStatus(Request $request, Order $order)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|string|in:dimasak,selesai,habis',
        ]);

        // Update status pesanan
        $order->status = $request->status;
        $order->save();

        alert()->success('Status pesanan berhasil diubah', 'Success');
        return redirect()->route('kitchen.index');
    }
}
