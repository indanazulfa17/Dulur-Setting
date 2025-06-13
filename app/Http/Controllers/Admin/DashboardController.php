<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalOrders' => Order::count(),
            'totalProducts' => Product::count(),
            'totalUsers' => User::count(),
            'totalRevenue' => Order::sum('total_price'),
            'latestOrders' => Order::with('product') // supaya relasi bisa dipakai di blade
    ->where('status', '!=', 'draft')     // hanya pesanan yang valid
    ->latest()
    ->take(5)
    ->get(),

        ]);
        
    }
}

