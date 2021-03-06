<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // N:N con tiendas
    public function shops() 
    {
        return $this->belongsToMany('App\Shop');
    }
}
