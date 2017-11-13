<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DB;

class ProductController extends Controller
{

    public static function getCategoriesIdByUrl($url) {
        $urlParts = explode('/', $url);

        $ids = array('category_id' => null, 'subcategory_id' => null);

        if(isset($urlParts[2])) {
            $categoryId = DB::table('categories')->where('categories.url', $urlParts[2])->select('id')->get();
            if(isset($categoryId[0])) {
                $ids['category_id'] = $categoryId[0]->id;
            }
        }
        if(isset($urlParts[3])) {
            $subcategoryId = DB::table('categories')->where('categories.url', $urlParts[3])->select('id')->get();
            if(isset($subcategoryId[0])) {
                $ids['subcategory_id'] = $subcategoryId[0]->id;
            }
        }

        return $ids;
    }

    public function getMainProducts(Request $request) {
    	$products = DB::table('products')->orderBy(DB::raw('RAND()'))->get();
    	return response()->json(['products' => $products]);
    }

    public function searchAutocomplete(Request $request) {
    	$urlParts = explode('/', $request->path());
    	$query = '';
    	if(isset($urlParts[3])) {
    		$query = urldecode($urlParts[3]);
    	}
    	$products = DB::table('products')
    		->orWhere('title', 'LIKE', '%' . $query . '%')
    		->orWhere('description', 'LIKE', '%' . $query . '%')
    		->select('id', 'title', 'url')
    		->get();
    	return response()->json(['products' => $products]);
    }

    public function getProduct(Request $request) {
        $productUrl = explode('/', $request->path())[2];
        $product = DB::table('products')
            ->where('url', $productUrl)
            ->get();
        return response()->json(['product' => $product]);
    }

    public function getProductsByCategory(Request $request) {
        $products = [];
        $categories = [];
        $categoryIds = self::getCategoriesIdByUrl($request->path());

        if($categoryIds['category_id']) {
            $productsQuery = DB::table('products')
                ->join('product_categories', 'products.id', '=', 'product_categories.product_id')
                ->where('product_categories.category_id', $categoryIds['category_id']);
            $categories['category'] = DB::table('categories')->where('id', $categoryIds['category_id'])->get();
        }
        if($categoryIds['subcategory_id']) {
            $productsQuery->where('product_categories.subcategory_id', $categoryIds['subcategory_id']);
            $categories['subcategory'] = DB::table('categories')->where('id', $categoryIds['subcategory_id'])->get();
        }

        $products = $productsQuery->get();
        return response()->json(['products' => $products, 'categories' => $categories]);
    }

    public function getAllCategories(Request $request) {
        $categories = DB::table('categories')->get();
        $categoriesSorted = [];

        foreach ($categories as $key => $category) {
            if(!$category->parent_id) {
                $categoriesSorted[$category->id] = $category;
                $categoriesSorted[$category->id]->subcategories = [];
            }
        }

        foreach ($categories as $key => $category) {
            if($category->parent_id) {
                array_push($categoriesSorted[$category->parent_id]->subcategories, $category);
            }
        }

        return response()->json(['categories' => $categoriesSorted]);
    }
}
