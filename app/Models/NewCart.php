<?php

namespace App\Models;
use App\Models\Product;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewCart extends Model
{
    use HasFactory;
    public $table="new_carts";
   
    public function products(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }
    function users(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    protected $fillable=['id','user_id','product_id','quantity'];
}
