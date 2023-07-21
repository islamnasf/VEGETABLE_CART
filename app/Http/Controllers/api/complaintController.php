<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class complaintController extends Controller
{
    public function index(){
        $comp=Complaint::Select("*")->orderby("id","ASC")->get(); //get() //paginate(2)
        if($comp ->count() > 0){
            return response()->json([
                'status'=>200,
                //'$questions'=> questionResource::collection($questions)
                'question'=> $comp
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Records Found '
            ],404);
        }
    }

    public function store(Request $Request){
        $comp = Complaint::create([
            'name'=> $Request->name,
            'pone'=>$Request->phone,
            'subject'=>$Request->subject

        ]);
        if($comp){
            return response()->json([
                'stetus'=>200,
                'message'=>"Complaint Created Successfully"
            ],200); 

        }else{
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);
            }
    
        
    }

    public function destroy($complaint){
        $comp = Complaint::where('id',$complaint)
        ->first();
        if($comp){
            $comp->delete();
            return response()->json([
                'stetus'=>200,
                'message'=>"Complaint Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such Complaint Found !"
            ],404);
        }
    } 
}
