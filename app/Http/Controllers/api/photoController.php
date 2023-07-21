<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Requests\photoRequest;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\support\str;

class photoController extends Controller
{
    public function index(){
        $photos=Photo::Select("*")->orderby("id","ASC")->get(); //get() //paginate(2)
        if($photos ->count() > 0){
            return response()->json([
                'status'=>200,
                //'photos'=> photoResource::collection($photos)
                'photos'=> $photos

            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Records Found '
            ],404);
        }
    }

    public function store(photoRequest  $Request){
        try{
            if($Request->hasFile('photo')){
               // $destination_path ='public/images/products';  
                $image = $Request->file('photo');
                $imageName=$image->getClientOriginalName();
                $imagedb=$Request->file('photo')->Move('products',$imageName); 
            }
            Photo::create([
                'product_id'=> $Request->product_id,
                'photo'=>$imagedb
            ]);
            
             return response()->json([
                'stetus'=>200,
                'message'=>"photo Created Successfully"
            ],200); 
        }catch(\Exception $e){
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);

        }
    }
    public function show($photo){ 
        $photos = Photo::find($photo);
        if($photos){
            return response()->json([
                'stetus'=>200,
                'Category'=>$photos
            ],200); 
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such photo Found"
            ],404);
        }
    }
    public function update(photoRequest $Request , int $photo){
        $photos=photo::where('id',$photo)->first();
         if($Request->hasFile('photo')){
             //$destination_path ='public/images/categories';  
             $image = $Request->file('photo');
             $imageName=$image->getClientOriginalName();
             $Request->file('photo')->Move('products',$imageName); 
         }
         $photos->update([
                'photo'=>$imageName
         ]);
         if($photos){
             return response()->json([
                 'stetus'=>200,
                 'message'=>"photo Updated Successfully"
             ],200); 
         }else{
             return response()->json([
                 'stetus'=>404,
                 'message'=>"No Such photo Found !"
             ],404);
         }
     
     }
     public function destroy($photo){
        $photos=Photo::where('id',$photo)->first();
        if($photos){
            $photos->delete();
            return response()->json([
                'stetus'=>200,
                'message'=>"photo Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such photo Found !"
            ],404);
        }
    } 

    
}

