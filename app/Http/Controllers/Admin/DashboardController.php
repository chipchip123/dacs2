<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
    // app/Http/Controllers/Admin/DashboardController.php
    return view('admin.dashboard.dashboard', [
        'orderCount'    => Order::count(),
        'userCount'     => User::count(),
        'productCount'  => Product::count(),
        'revenueToday'  => Order::whereDate('created_at', today())->sum('total_price'),
    ]);

    }
}
