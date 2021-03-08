<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $fillable = [
        'name',
        'cellphone', 
        'email', 
        'turn_number', 
        'franchise_number', 
        'square_meters_required',
        'type',
        'state',
    ];
}
