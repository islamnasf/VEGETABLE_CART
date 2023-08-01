<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Requests\orderRequest;
use App\Http\Resources\orderResource;
use App\Models\Address;
use App\Models\AllOrder;
use App\Models\NewCart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class orderController extends Controller
{
    public function store(orderRequest $Request){
        $user_id=Auth::user()->id;
       // $total_price=NewCart::select("*")->where('user_id','=',$user_id)->sum('new_carts.total_price');
        $cart=NewCart::select("*")->with('products')
        ->where('user_id','=',$user_id)->get();
        $user=User::find($user_id);
        //total price
        $prices=NewCart::where('user_id',$user_id)
        ->join('products','products.id','=','new_carts.product_id')
        ->select('new_carts.quantity','products.price')
        ->get();
        $stocks=NewCart::where('user_id',$user_id)
        ->join('products','products.id','=','new_carts.product_id')
        ->select('new_carts.quantity','products.stock')
        ->get();
         $price_all =0;
           foreach($prices as $price){           
           $quantity=$price->quantity;
           $one_pro=$price->price;
           $price_all +=$quantity*$one_pro; 
          }

    if($cart ->count() > 0 ){
        foreach($stocks as $stock){           
            $error_in_stock = $stock->quantity > $stock->stock;
        }
        if($error_in_stock){
            return response()->json([
            'stetus'=>500,
            'message'=>"no quantity of Products Found "
            ],500);
        }   
            $allorder=AllOrder::create([
            'user_id'=> $user_id,
            'user_name'=> $user->name,
            'user_phone'=> $user->phone,
            'total_price'=> $price_all,
            //Request 
            //'status'=> $Request->status,
            'user_address'=> $Request->user_address,
            'notes'=> $Request->notes,
            'code'=> $Request->code,
            'payment_method'=> $Request->payment_method,
            'day'=> $Request->day,
            'houre'=> $Request->houre,
        ]);
    }else{
        return response()->json([
            'stetus'=>500,
            'message'=>"No Products Found "
        ],500);
    }
       foreach($cart as $cart){
             Order::create([
            'allOrder_id'=>$allorder->id,
           //product
            'product_id'=>$cart->product_id,
            'image'=>$cart->products->image,
            'product_name'=>$cart->products->name,
            'quantity'=>$cart->quantity,
        ]);
            $cart_id=$cart->id;
            $cart=NewCart::select("*")->where('id','=',$cart_id)->first();
            $cart->delete();
            DB::table('products')->where('id','=',$cart->product_id)->decrement('stock',$cart->quantity);
        }
        if($allorder){
            return response()->json([
                'stetus'=>200,
                'message'=>"Added New Order Successfully"
            ],200); 

        }else{
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);
        }
    }

    
    public function currentOrder(){
        $user_id=Auth::user()->id;
        $CurrentOrders=AllOrder::Select("*")
        ->with('orders')
        ->orderby("id","ASC")
        ->where('user_id','=',$user_id)
        ->where('status','=','waiting')
        ->orwhere('status','=','preparation')
        ->orwhere('status','=','in delivery')
        ->get(); 
        if($CurrentOrders ->count() > 0){
            return response()->json([
                'status'=>200,
                // 'Orders'=> $CurrentOrders->load('orders')
              'Order'=> orderResource::collection($CurrentOrders),
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Orders Found '
            ],404);
        }
    }
    
    public function finishOrder(){
        $user_id=Auth::user()->id;
        $FinishOrders=AllOrder::Select("*")
        ->orderby("id","ASC")
        ->where('user_id','=',$user_id)
        ->where('status','=','finish')
        ->orwhere('status','=','cancelled')
        ->get(); 
        if($FinishOrders ->count() > 0){
            return response()->json([
                'status'=>200,
                'Orders'=> orderResource::collection($FinishOrders),
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Orders Found '
            ],404);
        }   
    }

    //cancel order
    
    public function cancel($order){
        $user_id=Auth::user()->id; 
        $allorder=AllOrder::Select("*")
        ->orderby("id","ASC")
        ->where('id','=',$order)
        ->where('user_id','=',$user_id)
        ->where('status','=','waiting')
        ->orwhere('status','=','preparation')
        ->orwhere('status','=','in delivery')
        ->first(); 
        $orders=order::select("*")->with('products')
        ->where('allOrder_id','=',$order)
        ->get();
        if($allorder){
            $allorder->update(['status'=>'cancelled']);

        foreach($orders as $order){
               DB::table('products')
               ->where('id','=',$order->product_id)
               ->increment('stock',$order->quantity);
        }

            return response()->json([
                'status'=>200,
                'message'=>" Order  Cancelled Successfully",
                'Orders'=> $allorder
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Orders Found '
            ],404);
        }
    }
}
