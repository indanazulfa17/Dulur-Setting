<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

public function index()
{
    $ordersQuery = Order::where('status', '!=', 'draft');

    return view('admin.dashboard', [
        'totalOrders' => $ordersQuery->count(),
        'totalProducts' => Product::count(),
        'totalUsers' => DB::table(
            DB::raw("
                (SELECT DISTINCT 
                    CONCAT(LOWER(TRIM(customer_name)), '-', LOWER(TRIM(email)), '-', TRIM(whatsapp)) AS identity 
                 FROM orders
                 WHERE email IS NOT NULL AND whatsapp IS NOT NULL
                ) as sub")
        )->count(),
        'totalRevenue' => $ordersQuery->sum('total_price'),

        // hanya tampilkan pesanan status 'menunggu'
        'latestOrders' => Order::with('product')
            ->where('status', 'menunggu')
            ->latest()
            ->take(5)
            ->get(),
    ]);
}


}

