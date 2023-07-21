<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\reviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class reviewController extends Controller
{
    public function store(reviewRequest $Request){
       
        $user_id=Auth::user()->id;
        $review = Review::where('user_id',$user_id)
        ->where('product_id',$Request->product_id)
        ->first(); 
        if($review){
            return response()->json([
                'stetus'=>200,
                'message'=>"Review Created before",
            ],200);
        }else{
        $review = Review::create([
            'comment'=> $Request->comment,
            'rating'=>$Request->rating,
            'user_id'=>$user_id,
            'product_id'=>$Request->product_id
        ]);
    
        if($review){
            return response()->json([
                'stetus'=>200,
                'message'=>"Review Created Successfully"
            ],200); 

        }else{
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);
            }
    }
        
    }
    
    public function update(reviewRequest $Request,$review){
       
        $user_id=Auth::user()->id;
        $rev = Review::where('user_id',$user_id)
        ->where('product_id',$Request->product_id)
        ->where('id',$review)
        ->first(); 
       
        $rev->update([
            'comment'=> $Request->comment,
            'rating'=>$Request->rating,
            'user_id'=>$user_id,
            'product_id'=>$Request->product_id
        ]);
    
        if($rev){
            return response()->json([
                'stetus'=>200,
                'message'=>"Review updated Successfully"
            ],200); 

        }else{
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);
            
    }
        
    }
    
    public function destroy($review){
        $user_id=Auth::user()->id;
        $reviews = Review::where('user_id',$user_id)
        ->where('id',$review)
        ->first();
        if($reviews){
            $reviews->delete();
            return response()->json([
                'stetus'=>200,
                'message'=>"Review Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such Review Found !"
            ],404);
        }
    } 
}

