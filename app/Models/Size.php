<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['name', 'dimension'];

    // Relasi ke order (satu size dipakai banyak order)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi many-to-many ke product
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_size');
    }
}
