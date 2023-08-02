<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyOrder extends Model
{
    use HasFactory;
    public $table="my_orders";

    function delivers(){
        return $this->belongsTo('App\Models\Deliver','delivery_id','id');
    }
    public function all_orders(){
        return $this->belongsTo('App\Models\AllOrder','allOrder_id','id');
    }
   
    protected $fillable=['id','allOrder_id','delivery_id','paid','money','status'];
}
