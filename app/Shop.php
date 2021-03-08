<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'name',
        'web_site', 
        'cellphone_one', 
        'cellphone_two', 
        'location', 
        'attention_schedule', 
        'category_id',
        'image'
    ];
    /**
     * Una tienda pertenece a una cierta categoria
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    // N:N con productos
    public function products() 
    {
        return $this->belongsToMany('App\Product');
    }



    
}
