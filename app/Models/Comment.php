<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $table="comments";
   
    public function products(){
        return $this->belongsTo('App\Models\Product','product_id','id');

    }
    function users(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    protected $fillable=['id','user_id','product_id','comment'];}
