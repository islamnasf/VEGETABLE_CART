<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\countryRequest;
use App\Http\Resources\countryResource;
use App\Models\Country;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\support\str;


class countryController extends Controller
{
    public function index(){
        $country=Country::Select("*")->orderby("name","ASC")->get(); //get() //paginate(2)
        if($country ->count() > 0){
            return response()->json([
                'status'=>200,
                'country'=> countryResource::collection($country)
                //'country'=> $country

            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Records Found '
            ],404);
        }
    }
    public function store(countryRequest  $Request){
        try{
          
            $imageName =Str::random(32).".".$Request->image->getClientOriginalExtension();
           // $destination_path ='public/images/countries';  
           $imagedb= $Request->file('image')->Move('countries',$imageName); //php  artisan storage:link

            Country::create([
                'name'=> $Request->name,
                'key'=> $Request->key,
                'image'=>$imagedb
            ]);
            
           // Storage::disk('public')->put($imageName,file_get_contents($Request->image));
            return response()->json([
                'stetus'=>200,
                'message'=>"Country Created Successfully"
            ],200); 
        }catch(\Exception $e){
            return response()->json([
                'stetus'=>500,
                'message'=>"something went woring"
            ],500);

        }
    }
 
    public function update(countryRequest $Request , int $country){
        $coun=Country::where('id',$country)->first();
         if($Request->hasFile('image')){
         //    $destination_path ='public/images/countries';  
             $image = $Request->file('image');
             $imageName=$image->getClientOriginalName();
             $imagedb=$Request->file('image')->Move('countries',$imageName); 
         }
         $coun->update([
             'name'=> $Request->name,
             'key'=> $Request->key,
             'image'=>$imagedb
         ]);
         if($coun){
             return response()->json([
                 'stetus'=>200,
                 'message'=>"Country Updated Successfully"
             ],200); 
         }else{
             return response()->json([
                 'stetus'=>404,
                 'message'=>"No Such Found !"
             ],404);
         }
     
     }
     public function destroy($country){
        $coun=Country::where('id',$country)->first();
        if($coun){
            $coun->delete();
            return response()->json([
                'stetus'=>200,
                'message'=>"Country Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                'stetus'=>404,
                'message'=>"No Such country Found !"
            ],404);
        }
    } 
}
