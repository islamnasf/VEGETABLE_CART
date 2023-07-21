<?php

namespace App\Http\Controllers;

use App\Http\Requests\verifyRequest;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api',['except'=>['login','register']]);
    }
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'phone'=>'required',
            'city'=>'required',
            'phone_code'=>'required',
            'password'=>'required|confirmed|min:6',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $code_number=rand(100000,999999);
        $data = ['code_number' => $code_number];
        $user=User::create(array_merge(
            $validator->validated() + $data,
            ['password'=>bcrypt($request->password)]

        ));

        return response()->json([
            'message'=>'User successfully registered',
            'user' =>$user
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
        if(!$token=auth()->attempt($validator->validated())){
            return response()->json(['error'=>'Unauthorized'],401);
        }
        return $this->createNewToken($token);
    }
    public function createNewToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_tybe'=>'bearer',
            'expires_in'=>auth()->factory()->getTTl()*60,
            'user'=>auth()->user()


        ]); 
    }
    public function profile(){
        return response()->json(auth()->user());
    }
    public function logout(){
        auth()->logout();
        
        return response()->json([
            'message'=>'User logged out',
        ],201);
    }
    public function verify(verifyRequest $Request){
        $otp=$Request->validated();
        $data=User::where('code_number',$otp);
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
