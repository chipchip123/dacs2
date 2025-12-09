<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    // Lịch sử đơn
    public function history()
    {
        $orders = Order::where('user_id', auth()->id())
                       ->orderByDesc('order_id')
                       ->get();

        return view('client.orders.history', compact('orders'));
    }

    // Chi tiết đơn hàng
    public function detail($id)
    {
        $order = Order::where('order_id', $id)
                      ->where('user_id', auth()->id())
                      ->with('items.product')
                      ->firstOrFail();

        return view('client.orders.detail', compact('order'));
    }
}
