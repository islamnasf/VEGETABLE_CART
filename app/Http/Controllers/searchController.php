<?php

namespace App\Http\Controllers;

use App\Http\Resources\productResource;
use App\Models\Product;
use Illuminate\Http\Request;

class searchController extends Controller
{
    public function search (Request $Request){
        $name=$Request ->get('search');
        $product=Product::Select("*")->orderby("name","ASC")
        ->where('name','like','%'.$name.'%')
        ->orwhere('description','like','%'.$name.'%')->get(); 
        return response()->json([
            'stetus'=>200,
            'product'=> productResource::collection($product)
        ],200);
        
    }

    public function search_price (Request $Request){
      $min = $Request->min;
        $max = $Request->max;
        $sort = $Request->sort;
       // $all_products = Product::Select("*")->where('price', '>=',$min)
        //->where('price', '<=',  $max )->first();
        $all_products = Product::whereBetween('price',[$min, $max])->orderBy("price",$sort)
        ->get();
        if($all_products){
        return response()->json([
            'stetus'=>200,
            'product'=> $all_products
        ],200);
    }
    }
}
