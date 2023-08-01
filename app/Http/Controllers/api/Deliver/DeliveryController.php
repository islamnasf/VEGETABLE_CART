<?php

namespace App\Http\Controllers\api\Deliver;

use App\Http\Controllers\Controller;
use App\Http\Resources\orderResource;
use App\Models\AllOrder;
use App\Models\MyOrder;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function __construct(){
        $this->middleware('auth:deliver',['except'=>['']]);
    }
    //all_waiting_order
    public function index(){
        $orders=AllOrder::Select("*")->where('status','=','waiting')->orderby("id","ASC")->get(); //get() //paginate(2)
        if($orders ->count() > 0){
            return response()->json([
                'status'=>200,
                'orders'=> orderResource::collection($orders)
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Orders Found '
            ],404);
        }
    }

//Add to my order 
    public function store($order){  
        $delivery_id=Auth()->guard('deliver')->user()->id;
        $allorder=AllOrder::select("*")
        ->where('id','=',$order)
        ->where('status','=','waiting')
        ->first();
        if($order){
            $my_order=MyOrder::create([
                'delivery_id'=> $delivery_id,
                'allOrder_id'=> $order,
                //'status'=> $Request->status,
                'paid'=> $allorder->payment_method,
            ]);
            if($my_order){
                $allorder->update(['status'=>'preparation']);
            }
            return response()->json([
                'stetus'=>200,
                'message'=>"Added To My Order Successfully"
            ],200); 

        }else{
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);
        }
    }

        //finish order
        public function finish(Request $Request ,$order){
            $delivery_id=Auth()->guard('deliver')->user()->id;
            $myorder=MyOrder::Select("*")
            ->orderby("id","ASC")
            ->where('id','=',$order)
            ->where('delivery_id','=',$delivery_id)
            ->where('status','=','Preparing')
            ->orwhere('status','=','Prepared')
            ->first(); 
            if( $myorder){
            $allorder=AllOrder::select("*")
            ->where('id','=',$myorder->allOrder_id)
            ->first();
            }else{
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);
            }
            $money=$Request->money;
            if($allorder->total_price == $Request->money  ){
                $myorder->update([
                    'status'=>'finish',
                     'money'=> $money,
                ]);
                if($myorder){
                    $allorder->update(['status'=>'finish']);
                }
                return response()->json([
                    'stetus'=>200,
                    'message'=>"this order is finish"
                ],200); 
            }else{
                return response()->json([
                    'stetus'=>500,
                    'message'=>"something went woring"
                ],500);
            }
        }
    //All my current orders
    public function currentOrder(){
        $delivery_id=Auth()->guard('deliver')->user()->id;
        $CurrentOrders=MyOrder::Select("*")
        ->with('all_orders')
        ->orderby("id","Desc")
        ->where('delivery_id','=',$delivery_id)
        ->where('status','=','preparing')
        ->orwhere('status','=','prepared')
        ->get(); 
        if($CurrentOrders ->count() > 0){
            return response()->json([
                'status'=>200,
             'MyOrder'=> $CurrentOrders->load('all_orders')
              //'MyOrder'=> orderResource::collection($CurrentOrders),
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Orders Found '
            ],404);
        }
    }
    //All my finish orders
    
    public function finishOrder(){
        $delivery_id=Auth()->guard('deliver')->user()->id;
        $finishOrders=MyOrder::Select("*")
        ->with('all_orders')
        ->orderby("id","Desc")
        ->where('delivery_id','=',$delivery_id)
        ->where('status','=','finish')
        ->get(); 
        if($finishOrders ->count() > 0){
            return response()->json([
                'status'=>200,
             'MyOrder'=> $finishOrders->load('all_orders')
              //'MyOrder'=> orderResource::collection($finishOrders),
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Orders Found '
            ],404);
        }
    }
  


    }



