<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Controller - DashboardController
public function index()
{
    $ordersQuery = Order::where('status', '!=', 'draft');

    return view('admin.dashboard', [
        'totalOrders' => $ordersQuery->count(),
        'totalProducts' => Product::count(),
        'totalUsers' => User::count(),
        'totalRevenue' => $ordersQuery->sum('total_price'),
        'latestOrders' => $ordersQuery->with('product')->latest()->take(5)->get(),
    ]);
}

}

