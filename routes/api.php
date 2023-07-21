<?php

use App\Http\Controllers\api\addressController;
use App\Http\Controllers\api\cartController;
use App\Http\Controllers\api\categoryController;
use App\Http\Controllers\api\commentController;
use App\Http\Controllers\api\complaintController;
use App\Http\Controllers\api\countryController;
use App\Http\Controllers\api\favoriteController;
use App\Http\Controllers\api\orderController;
use App\Http\Controllers\api\photoController;
use App\Http\Controllers\api\productController;
use App\Http\Controllers\api\questionController;
use App\Http\Controllers\api\reviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\searchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware'=>'api','prefix'=>'auth'],function($router){
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    Route::get('/profile',[AuthController::class,'profile']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/verify',[AuthController::class,'verify']); 
});
Route::group(['middleware'=>'auth:api'],function($router){
//country
 Route::get('country',[countryController::class,'index']);
 Route::post('country',[countryController::class,'store']);
 Route::put('country/{id}/edit',[countryController::class,'update']);
 Route::delete('country/{id}/delete',[countryController::class,'destroy']);
//address
Route::get('address',[addressController::class,'index']);
Route::post('address',[addressController::class,'store']);
Route::put('address/{id}/edit',[addressController::class,'update']);
Route::delete('address/{id}/delete',[addressController::class,'destroy']);
//category
 Route::get('category',[categoryController::class,'index']);
 Route::post('category',[categoryController::class,'store'])->middleware('adminCheck');
 Route::get('category/{id}/show',[categoryController::class,'show']);
 Route::put('category/{id}/edit',[categoryController::class,'update']);
 Route::delete('category/{id}/delete',[categoryController::class,'destroy']);
//product
 Route::get('product',[productController::class,'index']);
 Route::post('product',[productController::class,'store'])->middleware('adminCheck');
 Route::get('product/{id}/show',[productController::class,'show']);
 Route::put('product/{id}/edit',[productController::class,'update']);
 Route::delete('product/{id}/delete',[productController::class,'destroy']);
//photos
 Route::get('photo',[photoController::class,'index']);
 Route::post('photo',[photoController::class,'store']);
 Route::get('photo/{id}/show',[photoController::class,'show']);
 Route::put('photo/{id}/edit',[photoController::class,'update']);
 Route::delete('photo/{id}/delete',[photoController::class,'destroy']);
//search
Route::post('search',[searchController::class,'search']);
Route::post('search_price',[searchController::class,'search_price']);
//comment
Route::post('comment',[commentController::class,'store']);
Route::delete('comment/{id}/delete',[commentController::class,'destroy']);
//ٌReview
Route::post('review',[reviewController::class,'store']);
Route::put('review/{id}/edit',[reviewController::class,'update']);
Route::delete('review/{id}/delete',[reviewController::class,'destroy']);
//Cart
Route::post('newCart',[cartController::class,'store']);
Route::get('newCart',[cartController::class,'show']);
Route::put('newCart/{id}/edit',[cartController::class,'update']);
Route::delete('newCart/{id}/delete',[cartController::class,'destroy']);
// order
Route::post('order',[orderController::class,'store']);
Route::get('currentOrder',[orderController::class,'CurrentOrder']); //CurrentOrder
Route::get('finishOrder',[orderController::class,'finishOrder']);  //finishOrder
Route::put('cancel/{id}',[orderController::class,'cancel']);   //cancelOrder
//favorite
Route::post('favorite/{id}',[favoriteController::class,'store']);//add favorite
Route::get('favorite',[favoriteController::class,'index']); //All favorite
//question
Route::get('question',[questionController::class,'index']);
Route::post('question',[questionController::class,'store']);
Route::put('question/{id}/edit',[questionController::class,'update']);
Route::delete('question/{id}/delete',[questionController::class,'destroy']);
//complaint
Route::get('complaint',[complaintController::class,'index']);
Route::post('complaint',[complaintController::class,'store']);
Route::put('complaint/{id}/edit',[complaintController::class,'update']);
Route::delete('complaint/{id}/delete',[complaintController::class,'destroy']);
});
