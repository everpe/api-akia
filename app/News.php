<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'category_id',
    ];
    /**
     * Una Noticia pertenece a una cierta categoria
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
