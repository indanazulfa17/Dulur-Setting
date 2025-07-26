<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    // Set locale Carbon ke bahasa Indonesia
        Carbon::setLocale(config('app.locale'));

        // Share produk ke navbar-pelanggan
    View::composer('layouts.partials.navbar-pelanggan', function ($view) {
        $produkNavbar = Product::with('category')->orderBy('name')->get(); // ambil semua produk (atau bisa dibatasi)
        $view->with('produkNavbar', $produkNavbar);
    });

    View::composer('layouts.partials.footer-pelanggan', function ($view) {
    $groupedProducts = Product::with('category')
        ->orderBy('name')
        ->get()
        ->groupBy(function ($product) {
            return $product->category->name ?? 'Lainnya';
        });

    $view->with('groupedProducts', $groupedProducts);
});

Paginator::useBootstrap();

}

}