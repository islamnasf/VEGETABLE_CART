<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\cartRequest;
use App\Http\Resources\cartResource;
use App\Models\NewCart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cartController extends Controller
{
    public function store(cartRequest $Request){
            $user_id=Auth::user()->id;
            $product = NewCart::where('product_id',$Request->product_id)->first();   
            if($product){
                $product->update([
                    'user_id'=>$user_id,
                    'product_id'=>$Request->product_id,
                    'quantity'=>$Request->quantity,
                ]);
                return response()->json([
                    'stetus'=>200,
                    'message'=>" CartItems updated Successfully"
                ],200);
            }else{
            $newCart = NewCart::create([
                'user_id'=>$user_id,
                'product_id'=>$Request->product_id,
                'quantity'=>$Request->quantity,
            ]);

            if($newCart){
                return response()->json([
                    'stetus'=>200,
                    'message'=>"Added To CartItems Successfully"
                ],200); 
    
            }else{
                return response()->json([
                    'stetus'=>500,
                    'message'=>"something went woring"
                ],500);
                }
            }
        
        }

        public function update(cartRequest $Request,$cart){
            $user_id=Auth::user()->id;
            $product = NewCart::where('id',$cart)
            ->first();   
            $product->update([
                'user_id'=>$user_id,
                'product_id'=>$Request->product_id,
                'quantity'=>$Request->quantity,
                //'price'=> $product->price,
             // 'total_price'=>$product->price * $Request->quantity,

            ]);
            if($product){
                return response()->json([
                    'stetus'=>200,
                    'message'=>"updated To CartItems Successfully"
                ],200); 
    
            }else{
                return response()->json([
                    'stetus'=>500,
                    'message'=>"something went woring"
                ],500);
                }
        
        }

        public function show(){
            $user_id=Auth::user()->id;

           $data=NewCart::where('user_id',$user_id)
           ->join('products','products.id','=','new_carts.product_id')
            ->get();
        $prices=NewCart::where('user_id',$user_id)
        ->join('products','products.id','=','new_carts.product_id')
        ->select('new_carts.quantity','products.price')
        ->get();
         $price_all =0;
           foreach($prices as $price){           
           $quantity=$price->quantity;
           $one_pro=$price->price;
           $price_all +=$quantity*$one_pro; 
          }
           if($data){
            return response()->json([
                'status'=>200,
                //'cart'=> $data ,
                'cart'=> cartResource::collection($data),
                '$total_price'=>$price_all,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Records Found '
            ],404);
        
    }
          
         } 

         public function destroy($cart){
            $user_id=Auth::user()->id;
            $carts=NewCart::where('id',$cart)
            ->where('user_id',$user_id)
            ->first();
            if($carts){
                $carts->delete();
                return response()->json([
                    'stetus'=>200,
                    'message'=>"product Removed Successfully"
                ],200);
            }else{
                return response()->json([
                    'stetus'=>404,
                    'message'=>"No Such product Found !"
                ],404);
            }
        } 
    
     }




