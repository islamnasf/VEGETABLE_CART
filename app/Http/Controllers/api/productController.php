<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\productRequest;
use App\Http\Resources\productResource ;
use App\Http\Resources\reviewResource;
use App\Models\Image;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Notifications\newProductNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use Illuminate\support\str;


class productController extends Controller
{
    public function index(){
        $product=Product::Select("*")->orderby("name","ASC")->get(); //get() //paginate(2)
        if($product ->count() > 0){
            return response()->json([
                'status'=>200,
                 'product'=> ProductResource::collection($product)
                //'product'=> $product

            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Records Found '
            ],404);
        }
    }
    public function store(productRequest  $Request){
        try{
        
          $imageName =Str::random(32).".".$Request->image->getClientOriginalExtension();
    // $destination_path ='public/images/products';  
          $imagedb=$Request->file('image')->move('productImage',$imageName); //php  artisan storage:link
          $product=Product::create([
                'name'=> $Request->name,
                'category_id'=> $Request->category_id,
                'price'=> $Request->price,
                'discount'=> $Request->discount,
                'description'=> $Request->description,
                'code'=> $Request->code,
                'weight'=> $Request->weight,
                'stock'=> $Request->stock,
                'image'=>$imagedb
            ]);
             //photos
            foreach($Request->photo as $image ){   
                $photoName =Str::random(32).".".$image->getClientOriginalExtension();                          
                //$destination_path ='public/images/products';  
                $imagedb=$image->Move('productImage',$photoName);
                    Photo::create([
                    'product_id'=> $product->id,
                    'photo'=>$imagedb
                    ]);
                    
           }
           $user=User::where('role', '=', 'user')->get();
           Notification::send($user,new newProductNotification($product->name));
            return response()->json([
                'stetus'=>200,
                'message'=>"Product Created Successfully"
            ],200); 
        }catch(\Exception $e){
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);

        }
    }
    public function show($pro){ 
        $product = Product::find($pro);
        $reviews =Review::where('product_id',$pro)->get();
        if($pro){
            return response()->json([
                'stetus'=>200,
                'product'=> ProductResource::make($product),
                'reviews'=> reviewResource::collection($reviews)
            ],200); 
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such Product Found"
            ],404);
        }
    }
    public function update(productRequest $Request , int $product){
        $pro=Product::where('id',$product)->first();
         if($Request->hasFile('image')){
            // $destination_path ='public/images/products';  
             $image = $Request->file('image');
             $imageName=$image->getClientOriginalName();
             $Request->file('image')->Move('productImage',$imageName); 
         }
         $pro->update([
                'name'=> $Request->name,
                'category_id'=> $Request->category_id,
                'price'=> $Request->price,
                'Discount'=> $Request->Discount,
                'description'=> $Request->description,
                'code'=> $Request->code,
                'weight'=> $Request->weight,
                'stock'=> $Request->stock,
                'image'=>$imageName
         ]);

         if($pro){
            //photos
            $Photos=Photo::where('product_id',$product)->first();
            foreach($Request->photo as $image ){   
                $photoName =Str::random(32).".".$image->getClientOriginalExtension();                          
               // $destination_path ='public/images/products';  
                $imagedb=$image->Move('productImage',$photoName);
                $Photos->update([
                    'product_id'=>$product,
                    'photo'=>$imagedb
                    ]);
                    
           }
           
             return response()->json([
                 'stetus'=>200,
                 'message'=>"Product Updated Successfully"
             ],200); 
         }else{
             return response()->json([
                 'stetus'=>404,
                 'message'=>"No Such product Found !"
             ],404);
         }
     
     }
     public function destroy($product){
        $pro=Product::where('id',$product)->first();
        if($pro){
            $pro->delete();
            return response()->json([
                'stetus'=>200,
                'message'=>"product Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such product Found !"
            ],404);
        }
    } 

}
