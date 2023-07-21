<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $table="orders";
   
    public function products(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }
    public function allorders(){
        return $this->belongsTo('App\Models\AllOrder','allOrder_id','id');
    }
    protected $fillable=['id','product_id','allOrder_id','quantity','product_name','image'];
}
