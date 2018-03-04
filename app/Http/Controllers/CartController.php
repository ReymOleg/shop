<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getCart() {
        $cart = DB::table('cart')
            ->join('products', 'cart.product_id', 'products.id')
            ->where('cart.user_id', Auth::user()->id)
            ->select('products.*', 'cart.*', 'cart.id as cart_id')
            ->get();

        return $cart;
    }

    public function index(Request $request) {
        $cart = $this->getCart();
        return response()->json(['cart' => $cart]);
    }

    public function add(Request $request) {
        $count = $request['count'] ? $request['count'] : 1;
        $productId = $request['product_id'];

        $issetProduct = DB::table('cart')
                            ->where('product_id', $productId)
                            ->where('user_id', Auth::user()->id)
                            ->get();

        if (count($issetProduct)) {
            DB::table('cart')
                ->where('product_id', $productId)
                ->update([
                    'count' => $request['count'] ? $request['count'] : ++$issetProduct[0]->count
                ]);
        } else {
            DB::table('cart')
                ->insert([
                    'product_id' => $productId,
                    'user_id' => Auth::user()->id,
                    'count' => $count
                ]);
        }

        $cart = $this->getCart();
        return response()->json(['cart' => $cart]);
    }

    public function delete(Request $request) {
        DB::table('cart')->where('id', $request['cart_id'])->delete();

        $cart = $this->getCart();
        return response()->json(['cart' => $cart]);
    }

    public function checkout(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
        ]);

        $cart = $this->getCart();

        // TODO: create table order_product and write products to orders from cart
        // dd($cart);

        return response()->json(['cart' => $cart]);
    }
}
