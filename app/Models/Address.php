<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    public $table="addresses";
   
    
    function users(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    protected $fillable=['id','user_id','address','addressDetails','price'];
}
