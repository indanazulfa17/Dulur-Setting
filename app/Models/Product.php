<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'base_price', 'category_id',
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi ke banyak gambar (product_images)
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Ambil satu gambar utama (bisa gambar pertama)
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->oldestOfMany();
    }
}



