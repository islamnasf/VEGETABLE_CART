<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class commentController extends Controller
{
    public function store(Request $Request){
        $user_id=Auth::user()->id;
       // $post_id=Post::find($post);
        $comment = Comment::create([
            'comment'=> $Request->comment,
            'user_id'=>$user_id,
            'product_id'=>$Request->product_id
        ]);
        if($comment){
            return response()->json([
                'stetus'=>200,
                'message'=>"comment Created Successfully"
            ],200); 

        }else{
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);
            }
    }
    public function destroy($comment){
        //$posts = Post::find($post);
        $comments=Comment::with('users')->where('id',$comment)->first();
        if($comments){
            $comments->delete();
            return response()->json([
                'stetus'=>200,
                'message'=>"comment Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such comment Found !"
            ],404);
        }
    } 
}

