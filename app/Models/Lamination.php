<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lamination extends Model
{
    // Pastikan bisa mass assign name dan additional_price
    protected $fillable = ['name', 'additional_price'];

    // Relasi ke order (satu material dipakai banyak order)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi many-to-many ke produk (jika kamu buat tabel pivot material_product)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'lamination_product');
    }
}
