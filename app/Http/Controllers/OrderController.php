<?php

namespace App\Http\Controllers;

// Mengimpor semua Model dan Facade yang diperlukan
use Illuminate\Http\Request;
use App\Models\Tax;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Models\Card;
use App\Models\Table;
use Illuminate\Support\Facades\DB; // Untuk transaction
use PDF; // Untuk cetak PDF

class OrderController extends Controller
{
    /**
     * Menampilkan halaman utama kasir (penjualan).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Logika untuk pencarian produk
        if($request->search){
            $data['products'] = Product::orderBy('id', 'ASC')->where('name_product', 'LIKE', '%' . $request->search . '%')->get();
        }else{
            $data['products'] = Product::orderBy('id', 'ASC')->paginate(12);
        }
        
        $data['tax'] = Tax::firstOrCreate(['id' => 1], ['name' => 'PPN', 'value' => 11]);
        $data['category'] = Category::all();
        $data['carts'] = Cart::where('is_active', 1)->get();
        $data['tables'] = Table::all();
        $data['card'] = Card::pluck('name_card', 'id');

        return view('order.index', $data);
    }

    /**
     * Mengambil detail satu produk untuk ditampilkan di modal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Product
     */
    public function detail(Request $request)
    {
        return Product::findOrFail($request->id);
    }

    /**
     * Menyimpan pesanan baru dari kasir ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Order|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $carts = Cart::where('is_active', 1)->with('product')->get();

            if ($carts->isEmpty()) {
                return response()->json(['error' => 'Keranjang Anda kosong.'], 400);
            }
            
            foreach ($carts as $cart) {
                $product = Product::find($cart->product_id);
                if ($product->stock < $cart->qty) {
                    return response()->json(['error' => 'Stok ' . $product->name_product . ' tidak mencukupi.'], 400);
                }
            }

            $order = Order::create([
                'invoice'       => 'INV'.date('ymdHis'),
                'user_id'       => auth()->id(),
                'table_id'      => $request->table_id,
                'payment'       => $request->payment,
                'total'         => $request->total,
                'status'        => 'pending',
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cart->product_id,
                    'qty'        => $cart->qty,
                    'price'      => $cart->product->price,
                ]);
                
                $product = Product::find($cart->product_id);
                $product->stock -= $cart->qty;
                $product->save();
            }

            Cart::where('is_active', 1)->delete();
            return $order;
        });
    }
    
    /**
     * Menampilkan halaman pratinjau invoice sebelum dicetak.
     *
     * @param  string  $inv  Nomor Invoice
     * @return \Illuminate\View\View
     */
    public function cetak($inv)
    {
        $data['tax'] = Tax::firstOrCreate(['id' => 1], ['name' => 'PPN', 'value' => 11]);
        $data['order'] = Order::where('invoice', $inv)->with('items.product', 'table', 'user')->firstOrFail();
        return view('order.cetak', $data);
    }

    /**
     * Membuat dan menampilkan struk PDF untuk di-print.
     *
     * @param  string  $inv  Nomor Invoice
     * @return \Illuminate\Http\Response
     */
    public function print($inv)
    {
        $data['tax'] = Tax::firstOrCreate(['id' => 1], ['name' => 'PPN', 'value' => 11]);
        $data['setting'] = Setting::firstOrCreate(['id' => 1], ['name' => 'CAFFEE_IN', 'address' => 'Alamat Default']);
        $data['order'] = Order::where('invoice', $inv)->with('items.product', 'table', 'user')->firstOrFail();
        
        $customPaper = array(0,0,226.77,500);
    
        $pdf = PDF::loadview('order.print', $data)->setPaper($customPaper, 'portrait');
        return $pdf->stream();
    }
    
    /**
     * Mengonfirmasi pembayaran untuk sebuah pesanan.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmPayment(Order $order)
    {
        // Ubah status pembayaran menjadi 'lunas' atau metode spesifik
        $order->payment = 'QRIS'; // Anda bisa ganti menjadi 'Lunas' atau lainnya
        $order->save();

        alert()->success('Pembayaran berhasil dikonfirmasi', 'Success');
        // Kembali ke halaman sebelumnya (dalam kasus ini, halaman Dapur)
        return redirect()->back();
    }
}
