<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function store(Request $request)
    {

        $data = Cart:: where('product_id', $request->product_id)->where('is_active', 1)->first();
        if(!empty($data)){
            $cart = Cart::where('id', $data['id'])->first();
            $cart->qty = $data['qty'] + $request->qty;
            $cart->save();
        }else{
            $input = $request->all();
            $input['is_active'] = 1;
            Cart::create($input);
        }

        return 'success';

    }

    public function delete(Request $request)
    {
        $model = Cart::where('id', $request->id)->delete();
        return 'success';
    }
}
