<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class questionController extends Controller
{
    public function index(){
        $questions=Question::Select("*")->orderby("question","ASC")->get(); //get() //paginate(2)
        if($questions ->count() > 0){
            return response()->json([
                'status'=>200,
                //'$questions'=> questionResource::collection($questions)
                'question'=> $questions
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Records Found '
            ],404);
        }
    }
    public function store(Request $Request){
        $question = Question::create([
            'question'=> $Request->question,
            'answer'=>$Request->answer
        ]);
        if($question){
            return response()->json([
                'stetus'=>200,
                'message'=>"Question Created Successfully"
            ],200); 

        }else{
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);
            }
    
        
    }
    
    public function update(Request $Request,$question){
       
        $questions =Question::where('id',$question)->first(); 
       
        $questions->update([
            'question'=> $Request->question,
            'answer'=>$Request->answer
        ]);
    
        if($questions){
            return response()->json([
                'stetus'=>200,
                'message'=>"Question updated Successfully"
            ],200); 

        }else{
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);
            
    }
        
    }
    public function show($question){ 
        $questions = Question::find($question);
        if($questions){
            return response()->json([
                'stetus'=>200,
                //'$questions'=> qustionResource::make($questions),
                '$questions'=> $questions,

            ],200); 
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such Qustion Found"
            ],404);
        }
    }
    
    public function destroy($question){
        $questions = Question::where('id',$question)
        ->first();
        if($questions){
            $questions->delete();
            return response()->json([
                'stetus'=>200,
                'message'=>"Question Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such Question Found !"
            ],404);
        }
    } 
}
