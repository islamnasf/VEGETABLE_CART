<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\addressRequest;
use App\Http\Resources\addressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class addressController extends Controller
{
    public function index(){
        $address=Address::Select("*")->orderby("address","ASC")->get(); //get() //paginate(2)
        if($address ->count() > 0){
            return response()->json([
                'status'=>200,
                'Address'=> addressResource::collection($address)
                //'address'=> $address
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Records Found '
            ],404);
        }
    }
    public function store(addressRequest $Request){
       
        $user_id=Auth::user()->id;
   
        $address = Address::create([
            'address'=> $Request->address,
            'user_id'=>$user_id,
            'addressDetails'=>$Request->addressDetails
        ]);
    
        if($address){
            return response()->json([
                'stetus'=>200,
                'message'=>"Address Created Successfully"
            ],200); 

        }else{
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);
            }
    
        
    }
    
    public function update(addressRequest $Request,$address){
       
        $user_id=Auth::user()->id;
        $add = Address::where('user_id',$user_id)
        ->where('id',$address)
        ->first(); 
       
        $add->update([
            'address'=> $Request->address,
            'user_id'=>$user_id,
            'addressDetails'=>$Request->addressDetails
        ]);
    
        if($add){
            return response()->json([
                'stetus'=>200,
                'message'=>"Address updated Successfully"
            ],200); 

        }else{
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);
            
    }
        
    }
    
    public function destroy($address){
        $user_id=Auth::user()->id;
        $add = Address::where('user_id',$user_id)
        ->where('id',$address)
        ->first();
        if($add){
            $add->delete();
            return response()->json([
                'stetus'=>200,
                'message'=>"Address Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such Address Found !"
            ],404);
        }
    } 
}

