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

    public function checkout(Request $request) {
        $products = $this->getCart();
    }
}
