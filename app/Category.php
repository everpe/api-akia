<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];
    /**
     * Una Categoria tiene muchas Noticias
     */
    public function news() 
    {
        return $this->belongsToMany('App\News');
    }


    /**
     * Una Categoria tiene muchas tiendas
     */
    public function shops() 
    {
        return $this->belongsToMany('App\Shop');
    }
    
}
