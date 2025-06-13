<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;

class SizesTableSeeder extends Seeder
{
    public function run()
    {
        $sizes = [
            ['name' => 'A4', 'dimension' => '210mm x 297mm'],
            ['name' => 'A3', 'dimension' => '297mm x 420mm'],
            ['name' => 'A5', 'dimension' => '148mm x 210mm'],
            ['name' => 'Custom', 'dimension' => 'Variabel'],
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }
    }
}

