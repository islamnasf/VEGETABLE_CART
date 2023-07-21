<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllOrder extends Model
{
    use HasFactory;
    public $table="all_orders";

    function users(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function orders(){
        return $this->hasMany('App\Models\Order','allOrder_id');
    }
   
    protected $fillable=['id','user_id','user_name','user_phone','user_address','status',
    'notes','code','payment_method','total_price','day','houre'];
}
