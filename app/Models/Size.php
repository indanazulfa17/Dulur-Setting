<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['name', 'dimension'];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}


