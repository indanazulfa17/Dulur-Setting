<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Cetak Brosur A5',
            'description' => 'Cetak brosur ukuran A5 full color.',
            'image' => 'brosur_a5.jpg',
            'category_id' => 1,
            'base_price' => 15000,
            'form_fields' => json_encode([
                [
                    'label' => 'Jenis Lipatan',
                    'name' => 'lipatan',
                    'type' => 'select',
                    'options' => ['Tanpa Lipatan', 'Z-Fold', 'Tri-Fold']
                ]
            ])
        ]);
    }
}
