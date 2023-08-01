<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyDeliverRequest;
use App\Http\Requests\verifyRequest;
use App\Models\Deliver;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Auth\Events\Verified;



class DeliverController extends Controller

{
    public function __construct(){
        $this->middleware('auth:deliver',['except'=>['login','register']]);
    }
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required|unique:delivers',
            'city'=>'required',
            'phone_code'=>'required',
            'password'=>'required|confirmed|min:6',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $code_number=rand(100000,999999);
        $data = ['code_number' => $code_number];
        $deliver=Deliver::create(array_merge(
            $validator->validated() + $data,
            ['password'=>bcrypt($request->password)]

        ));

        return response()->json([
            'message'=>'Deliver successfully registered',
            'deliver' =>$deliver
        ],201);
    }

    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            'phone_code'=>'required',
            'phone'=>'required',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        if(!$token=auth()->guard('deliver')->attempt($validator->validated())){
            return response()->json(['error'=>'Unauthorized'],401);
        }
        return $this->createNewToken($token);
    }
    public function createNewToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_tybe'=>'bearer',
            'expires_in'=>auth()->guard('deliver')->factory()->getTTl()*60,
           'deliver'=>auth()->guard('deliver')->user()

        ]); 
    }
    public function profile(){
       return response()->json(auth()->guard('deliver')->user());
    }
    public function logout(){
        auth()->guard('deliver')->logout();
        
        return response()->json([
            'message'=>'Deliver logged out',
        ],201);
    }
    
    public function verify(VerifyDeliverRequest $Request){
        $otp=$Request->validated();
        $data=Deliver::where('code_number',$otp);
        if($data->exists()){
            $data->update(['verify'=>'Verified']);
            return response()->json([
                'message'=>'your account is verified',
            ],201);
        }else{
            return response()->json([
                'message'=>'your account is not verified',
            ],201);

        }

    }
}
