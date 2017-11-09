<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DB;

class ProductController extends Controller
{
    public function getMainProducts(Request $request) {
    	$products = DB::table('products')->get();
    	return response()->json(['products' => $products]);
    }

    public function searchAutocomplete(Request $request) {
    	$url_parts = explode('/', $request->path());
    	$query = '';
    	if(isset($url_parts[3])) {
    		$query = urldecode($url_parts[3]);
    	}
    	$products = DB::table('products')
    		->orWhere('title', 'LIKE', '%' . $query . '%')
    		->orWhere('description', 'LIKE', '%' . $query . '%')
    		->select('id', 'title', 'url')
    		->get();
    	return response()->json(['products' => $products]);
    }
}
