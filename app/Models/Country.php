<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'key',
        'image'
    ];
    public  function getImageAttribute()
    {
        return isset($this->attributes['image']) ? asset($this->attributes['image']) : asset('');
    }
    public $table="countries"; 
}
