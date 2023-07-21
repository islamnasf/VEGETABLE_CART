<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = [
        'photo',
        'product_id',
    ];
    public  function getPhotoAttribute()
    {
        return isset($this->attributes['photo']) ? asset($this->attributes['photo']) : asset('');
    }

    public  function getImageAttribute()
    {
        return isset($this->attributes['photo']) ? asset($this->attributes['photo']) : asset('');
    }
    public function products(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
    public $table="photos"; 
  
}
