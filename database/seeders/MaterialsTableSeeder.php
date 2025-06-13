<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialsTableSeeder extends Seeder
{
    public function run()
    {
        $materials = ['Art Paper', 'HVS', 'Ivory', 'Karton'];

        foreach ($materials as $mat) {
            Material::create(['name' => $mat]);
        }
    }
}


