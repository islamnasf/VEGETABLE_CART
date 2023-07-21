<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\favoriteResource;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class favoriteController extends Controller
{
    public function index(){
        $user_id=Auth::user()->id;
        $favorites=Favorite::Select("*")
        ->with('products')
        ->where('user_id',$user_id)
        ->orderby("id","asc")
        ->get(); 

        if($favorites ->count() > 0){
            return response()->json([
                'status'=>200,
                'favorite'=> favoriteResource::collection($favorites)
               // 'favorite'=> $favorites

            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Records Found '
            ],404);
        }
    }

    public function store($product_id){
        $user_id=Auth::user()->id;
        $favorite = Favorite::where('user_id',$user_id)
                    ->where('product_id',$product_id)
                    ->first(); //get()
        if($favorite){
            $favorite->delete();
            return response()->json([
                'stetus'=>200,
                'message'=>"You removed a product frome your favorite",
            ],200);
        }else{
            $favorite=Favorite::create([
                'user_id'=>$user_id,
                'product_id'=>$product_id
            ]);   
            if($favorite->save())  {
                return response()->json([
                    'stetus'=>200,
                    'message'=>"You added a product to your favorite",

                ],200);
            }else{
                return response()->json([
                    'stetus'=>500,
                    'message'=>"something went woring"
                ],500);
            }
        }
    }
}
