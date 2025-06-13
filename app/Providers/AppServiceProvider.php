<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    View::composer('layouts.partials.navbar-pelanggan', function ($view) {
        $produkNavbar = Product::with('category')->orderBy('name')->get(); // ambil semua produk (atau bisa dibatasi)
        $view->with('produkNavbar', $produkNavbar);
    });
}

}
