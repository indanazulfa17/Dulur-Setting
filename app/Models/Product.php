<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'base_price', 'category_id', 'form_fields'
    ];

    protected $casts = [
        'form_fields' => 'array', // ✅ penting agar bisa digunakan di blade/form
    ];

    /**
     * Relasi ke kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke order.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relasi ke banyak gambar produk.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Gambar utama produk.
     */
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->oldestOfMany();
    }

    /**
     * Relasi ke bahan (materials) melalui tabel pivot material_product.
     */
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_product')
                    ->withPivot('additional_price')
                    ->withTimestamps();
    }

    /**
     * Relasi ke ukuran (sizes) melalui tabel pivot product_size.
     */
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size')
                    ->withPivot('additional_price')
                    ->withTimestamps();
    }

    /**
     * Relasi ke ukuran (laminations) melalui tabel pivot product_lamination.
     */
    public function laminations()
    {
        return $this->belongsToMany(Lamination::class, 'lamination_product')
                    ->withPivot('additional_price')
                    ->withTimestamps();
    }

    public function getFormFieldsDecodedAttribute()
{
    return json_decode($this->form_fields, true);
}

}
