<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategoriesTableSeeder::class,
            SizesTableSeeder::class,
            MaterialsTableSeeder::class,
            LaminationsTableSeeder::class,
            ProductsTableSeeder::class,
        ]);
    }
}
