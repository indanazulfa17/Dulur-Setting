<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lamination;

class LaminationsTableSeeder extends Seeder
{
    public function run()
    {
        $laminations = ['Glossy', 'Doff', 'Tanpa Laminasi'];

        foreach ($laminations as $lam) {
            Lamination::create(['name' => $lam]);
        }
    }
}


