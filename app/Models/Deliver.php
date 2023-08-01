<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
//use Illuminate\Database\Eloquent\Model;

class Deliver extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'city',
        'phone_code',
        'verify',
        'code_number',
        'car_name',
        'car_model',
        'front_car',
        'back_car',
        'bank_name',
        'iban'
    ];
    function my_orders(){
        return $this->hasMany('App\Models\MyOrder','delivery_id','id');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier()   
   		{
       			 return $this->getKey();
    	}

		public function getJWTCustomClaims()
    	{
        	return [];
    	}
}
