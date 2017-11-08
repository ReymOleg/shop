<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DB;

class ProductController extends Controller
{
    public function getProducts(Request $request) {
    	$products = DB::table('products')->get();
    	return response()->json(['products' => $products]);
    }
}
