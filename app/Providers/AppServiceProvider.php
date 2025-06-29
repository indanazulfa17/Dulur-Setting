<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

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
}

}
