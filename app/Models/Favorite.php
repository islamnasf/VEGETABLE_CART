<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    public $table="favorites";
   
    public function products(){
        return $this->hasMany('App\Models\Product','id','product_id');
    }
    function users(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    protected $fillable=['id','user_id','product_id'];
}
