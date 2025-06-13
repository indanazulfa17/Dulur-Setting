<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua data dengan cara aman
        Category::query()->delete();

        // Reset ID ke 1
        DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1');

        $categories = ['Percetakan', 'Digital Printing', 'Advertising'];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
            ]);
        }
    }
}
