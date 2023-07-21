<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
    ];
    public  function getImageAttribute()
    {
        return isset($this->attributes['image']) ? asset($this->attributes['image']) : asset('');
    }
    public function products(){
        return $this->hasMany('App\Models\Product','category_id','id');
    }
    public $table="categories"; 
}
