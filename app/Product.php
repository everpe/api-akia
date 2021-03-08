<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'image',
    ];
    // N:N con tiendas
    public function shops() 
    {
        return $this->belongsToMany('App\Shop');
    }
}
