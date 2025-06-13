<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'email',
        'whatsapp',
        'size_id',
        'material_id',
        'lamination_id',
        'quantity',
        'custom_description',
        'design_file',
        'price',
        'status',
        'payment_status',
        'payment_proof',
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


