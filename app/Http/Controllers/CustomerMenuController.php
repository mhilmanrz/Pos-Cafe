<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Table;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tax;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CustomerMenuController extends Controller
{
    /**
     * Menampilkan halaman menu utama untuk meja tertentu.
     */
    public function showMenu(Table $table)
    {
        $products = Product::where('stock', '>', 0)->orderBy('name_product', 'asc')->get();
        Session::put('table_id', $table->id);
        Session::put('table_name', $table->name);
        return view('customer.menu_table', compact('products', 'table'));
    }

    /**
     * Menambahkan produk ke keranjang session.
     */
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        if ($product->stock < 1) {
            return response()->json(['error' => 'Stok ' . $product->name_product . ' sudah habis.'], 400);
        }

        $cart = Session::get('customer_cart', []);

        if(isset($cart[$product->id])) {
            if ($product->stock <= $cart[$product->id]['quantity']) {
                return response()->json(['error' => 'Stok ' . $product->name_product . ' tidak mencukupi.'], 400);
            }
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name_product,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        
        Session::put('customer_cart', $cart);
        return response()->json(['success' => 'Produk berhasil ditambahkan!', 'cartCount' => count($cart)]);
    }

    /**
     * Menampilkan halaman keranjang belanja pelanggan.
     */
    public function showCart(Table $table)
    {
        $cart = Session::get('customer_cart', []);
        $tax = Tax::firstOrCreate(['id' => 1], ['name' => 'PPN', 'value' => 11]);
        return view('customer.cart', compact('cart', 'tax', 'table'));
    }
    
    /**
     * Memperbarui kuantitas item di keranjang.
     */
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity > 0){
            $cart = Session::get('customer_cart');
            $product = Product::find($request->id);
            if ($product->stock < $request->quantity) {
                return response()->json(['error' => 'Stok ' . $product->name_product . ' tidak mencukupi.'], 400);
            }
            $cart[$request->id]["quantity"] = $request->quantity;
            Session::put('customer_cart', $cart);
            return response()->json(['success' => 'Keranjang diperbarui!']);
        }
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function removeFromCart(Request $request)
    {
        if($request->id) {
            $cart = Session::get('customer_cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Session::put('customer_cart', $cart);
            }
            return response()->json(['success' => 'Produk dihapus!']);
        }
    }

    /**
     * Membuat pesanan baru dari keranjang pelanggan.
     */
    public function placeOrder(Request $request, Table $table)
    {
        return DB::transaction(function () use ($table) {
            $cart = Session::get('customer_cart', []);
            $tax = Tax::firstOrCreate(['id' => 1], ['name' => 'PPN', 'value' => 11]);

            if (empty($cart)) {
                return redirect()->back()->with('error', 'Keranjang kosong.');
            }
            
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if ($product->stock < $details['quantity']) {
                    return redirect()->route('customer.cart.show', ['table' => $table->id])->with('error', 'Stok ' . $product->name_product . ' tidak mencukupi.');
                }
            }

            $total = 0;
            foreach($cart as $id => $details) { $total += $details['price'] * $details['quantity']; }
            $total += ($total * $tax->value / 100);

            // Membuat catatan pesanan utama
            $order = Order::create([
                'invoice'       => 'CUST-'.date('ymdHis'),
                'user_id'       => null,
                'table_id'      => $table->id,
                // PERBAIKAN: Menggunakan 'payment' sesuai nama kolom di database
                'payment'       => 'pending', 
                'total'         => $total,
                'status'        => 'pending',
            ]);

            foreach ($cart as $id => $details) {
                OrderItem::create(['order_id' => $order->id, 'product_id' => $id, 'qty' => $details['quantity'], 'price' => $details['price']]);
                
                $product = Product::find($id);
                if ($product) {
                    $product->stock -= $details['quantity'];
                    $product->save();
                }
            }

            Session::forget('customer_cart');
            Session::forget('table_id');
            Session::forget('table_name');
            
            return redirect()->route('customer.order.track', $order->invoice);
        });
    }

    /**
     * Menampilkan halaman pelacakan pesanan.
     */
    public function showTrackingPage($invoice)
    {
        $order = Order::where('invoice', $invoice)->firstOrFail();
        $setting = Setting::firstOrCreate(['id' => 1], ['name' => 'CAFFEE_IN']);
        return view('customer.track_order', compact('order', 'setting'));
    }

    /**
     * Mengambil status pesanan terbaru untuk AJAX call.
     */
    public function getOrderStatus($invoice)
    {
        $order = Order::where('invoice', $invoice)->firstOrFail();
        return response()->json(['status' => $order->status]);
    }
}
