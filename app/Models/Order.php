<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id',
        'customer_name', // sesuaikan dengan form input dan validasi
        'email',
        'whatsapp',
        'size_id',
        'material_id',
        'lamination_id',
        'quantity',
        'custom_description',
        'dynamic_fields',
        'design_file',
        'total_price',   // gunakan total_price jika sudah pakai itu di controller
        'status',
        'payment_status',
        'payment_proof',
        'shipping_method',   // jika pakai shipping method
        'shipping_address',  // jika pakai alamat kirim
    ];

     // ✅ Cast ke array (untuk json encode/decode otomatis)
    protected $casts = [
        'dynamic_fields' => 'array',
        'form_fields' => 'array',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function lamination()
    {
        return $this->belongsTo(Lamination::class);
    }
}
