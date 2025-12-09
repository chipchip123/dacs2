<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingOrder;

class PaymentController extends Controller
{
    public function qrPage(Request $request)
    {
        $amount = $request->amount;
        $info   = $request->info;

        // Thông tin tài khoản ngân hàng
        $bank        = "MB";
        $accountNo   = "0812410710";
        $accountName = "Hua Gia Thinh";

        $qrUrl = "https://img.vietqr.io/image/{$bank}-{$accountNo}-compact.png?amount={$amount}&addInfo={$info}";

        return view('payment.qr', compact('amount', 'info', 'qrUrl', 'accountNo', 'accountName'));
    }

    // AJAX CHECK: xem pending order đã bị xoá chưa (đã thanh toán)
    public function checkPayment($code)
    {
        $pending = PendingOrder::where('code', $code)->first();

        if (!$pending) {

            // XÓA SESSION CART (double clean)
            session()->forget("cart");

            return response()->json(["paid" => true]);
        }

        return response()->json(["paid" => false]);
    }
}
