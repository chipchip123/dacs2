<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('client.cart.index', compact('cart'));
    }

    // Thêm vào giỏ (reload)
    public function add($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1
            ];
        } else {
            $cart[$id]['quantity']++;
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    // Xóa khỏi giỏ
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Đã xóa món khỏi giỏ');
    }

    // ============================
    // 🔥 Cập nhật số lượng AJAX
    // ============================
    public function updateAjax(Request $request)
    {
        $id  = $request->id;
        $qty = max(1, (int)$request->quantity);

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại trong giỏ!'
            ]);
        }

        // cập nhật số lượng
        $cart[$id]['quantity'] = $qty;
        session()->put('cart', $cart);

        // subtotal
        $subtotal = $cart[$id]['price'] * $cart[$id]['quantity'];

        // total
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal),
            'total' => number_format($total),
            'cartCount' => collect($cart)->sum(function ($item) {
                return $item['quantity'];
            })
        ]);
    }


    // ============================
    // 🔥 Thêm vào giỏ bằng AJAX
    // ============================
    public function addAjax(Request $request)
    {
        $id = $request->id;
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            $cart[$id] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => 1
            ];
        } else {
            $cart[$id]['quantity']++;
        }

        session()->put('cart', $cart);

        // render mini-cart
        $miniCartHtml = view('partials.client.mini-cart')->render();

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm vào giỏ hàng!',
            'miniCart' => $miniCartHtml,
            'cartCount' => collect($cart)->sum(function ($item) {
                return $item['quantity'];
            })
        ]);
    }
}
