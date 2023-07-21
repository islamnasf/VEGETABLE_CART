<?php

namespace App\Models;
use App\Models\Category;
use App\Models\Image;
use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'category_id',
        'price',
        'image',
        'description',
        'code',
        'discount',
        'weight',
        'stock'

    ];
    public $table="products"; 
    public function categories(){
        return $this->belongsTo('App\Models\Category','category_id','id');
    }
    public function photos(){
        return $this->hasMany('App\Models\Photo','product_id','id');
    }
    public function images(){
        return $this->morphMany('App\Models\Image','imagable');

    }
    public function new_carts()
    {
        return $this->belongsTo('App\Models\NewCart','product_id','id');    
    }
    public function orders()
    {
        return $this->belongsTo('App\Models\Order','product_id','id');    
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment','product_id','id');

    }
    public function reviews(){
        return $this->hasMany('App\Models\Review','product_id','id');

    }
    public function favorites(){
        return $this->belongsTo('App\Models\Favorite','product_id','id');

    }
    
    public  function getImageAttribute()
    {
        return isset($this->attributes['image']) ? asset($this->attributes['image']) : asset('');
    }

   /* public  function setWeightAttribute($value)
    {
        return $this->attributes['weight'] = $value * 1000;
    }*/
    
}
