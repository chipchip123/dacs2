<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingOrder;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (!$cart) {
            return redirect('/cart')->with('error', 'Giỏ hàng trống.');
        }

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        return view('client.checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session('cart', []);

        if (!$cart) {
            return redirect('/cart')->with('error', 'Giỏ hàng trống.');
        }

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        if ($request->payment === 'cod') {
            return $this->createOrderNow($cart, $total);
        }

        // Banking
        $paymentCode = "PAY-" . auth()->id() . "-" . time();

        PendingOrder::create([
            'user_id' => auth()->id(),
            'code'    => $paymentCode,
            'cart'    => $cart,
            'total'   => $total
        ]);

        return redirect()->route('payment.qr', [
            'amount' => $total,
            'info'   => $paymentCode
        ]);
    }

    public function createOrderNow($cart, $total)
    {
        $order = \App\Models\Order::create([
            'user_id'     => auth()->id(),
            'total_price' => $total,
            'status'      => 'paid'
        ]);

        foreach ($cart as $productId => $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        session()->forget('cart');

        return redirect('/')->with('success', 'Đặt hàng thành công!');
    }
}
