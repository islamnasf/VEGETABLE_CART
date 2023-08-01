<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\categoryAddedRequest;
use App\Http\Requests\categoryUpdatedRequest;
use App\Http\Resources\categoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\support\str;

class categoryController extends Controller
{
    public function index(){
        $category=Category::Select("*")->orderby("name","ASC")->paginate(4); //get() //paginate(2)
        if($category ->count() > 0){
            return response()->json([
                'status'=>200,
                'category'=> categoryResource::collection($category)
                //'category'=> $category

            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Records Found '
            ],404);
        }
    }
    public function store(categoryAddedRequest  $Request){
        try{
            
            $imageName =Str::random(32).".".$Request->image->getClientOriginalExtension();
           // $destination_path ='public/images/categories';  
            $imagedb=$Request->file('image')->Move('Categories',$imageName);
            Category::create([
                'name'=> $Request->name,
                'image'=>$imagedb
            ]);
            //php  artisan storage:link
            return response()->json([
                'stetus'=>200,
                'message'=>"Category Created Successfully"
            ],200); 
        }catch(\Exception $e){
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);

        }
    }
    public function show( $cat){ 
        $category = category::find($cat);
        if($category){
            return response()->json([
                'stetus'=>200,
               // 'Category'=>$category,
                'Category'=> categoryResource::make($category)

            ],200); 
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such Category Found"
            ],404);
        }
    }
    public function update(categoryUpdatedRequest $Request , int $category){
        $cat=Category::where('id',$category)->first();
         if($Request->hasFile('image')){
            // $destination_path ='public/images/categories';  
             $image = $Request->file('image');
             $imageName=$image->getClientOriginalName();
             $imagedb= $Request->file('image')->Move('Categories',$imageName); 
         }
         $cat->update([
                'name'=> $Request->name,
                'image'=>$imagedb
         ]);
         if($cat){
             return response()->json([
                 'stetus'=>200,
                 'message'=>"Category Updated Successfully"
             ],200); 
         }else{
             return response()->json([
                 'stetus'=>404,
                 'message'=>"No Such Category Found !"
             ],404);
         }
     
     }
     public function destroy($category){
        $cat=Category::where('id',$category)->first();
        if($cat){
            $cat->delete();
            return response()->json([
                'stetus'=>200,
                'message'=>"Category Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such Category Found !"
            ],404);
        }
    } 

}
