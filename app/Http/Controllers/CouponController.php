<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $code = $request->coupon;
        $cart = session()->get('cart', []);

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Giỏ hàng trống']);
        }

        $coupon = Coupon::where('code', $code)
            ->where('active', 1)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ!']);
        }

        // Tổng tiền giỏ hàng
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Tính giảm giá
        $discountAmount = ($total * $coupon->discount_value) / 100;

        if ($coupon->max_discount) {
            $discountAmount = min($discountAmount, $coupon->max_discount);
        }

        // Lưu vào session
        session()->put('discount', $discountAmount);
        session()->put('discount_code', $coupon->code);

        return response()->json([
            'success' => true,
            'discount' => number_format($discountAmount),
            'final_total' => number_format($total - $discountAmount),
            'message' => 'Áp dụng mã giảm giá thành công!'
        ]);
    }
}
