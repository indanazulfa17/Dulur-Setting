<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lamination extends Model
{
    protected $fillable = ['name'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
