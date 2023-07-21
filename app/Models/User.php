<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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
        //'image',
        'city',
        'phone_code',
        'verify',
        'code_number'

    ];
    public function comments(){
        return $this->hasMany('App\Models\Comment','user_id','id');
    }
    public function reviews(){
        return $this->hasMany('App\Models\Review','user_id','id');
    }
    public function addresses(){
        return $this->hasMany('App\Models\Address','user_id','id');
    }
    public function allorders(){
        return $this->hasMany('App\Models\AllOrders','user_id','id');
    }
    public function favorites(){
        return $this->hasMany('App\Models\Favorits','product_id','id');

    }
    public function carts():HasMany
    {
        return $this->hasMany(NewCart::class);    
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

