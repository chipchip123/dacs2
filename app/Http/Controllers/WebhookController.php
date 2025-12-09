<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingOrder;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function receive(Request $request)
    {
        Log::info("WEBHOOK_HIT", $request->all());

        // Tin nhắn Telegram (mã thanh toán)
        $content = $request->message["text"] ?? null;
        Log::info("CONTENT_RECEIVED", ["content" => $content]);

        if (!$content) {
            return "NO_CONTENT";
        }

        // Tìm pending order theo CODE (VD: PAY-9-17647xxxx)
        $pending = PendingOrder::where("code", $content)->first();

        if (!$pending) {
            Log::info("NO_PENDING_MATCH");
            return "NO_MATCH";
        }

        Log::info("PENDING_FOUND", $pending->toArray());

        // Tạo đơn chính thức
        $order = Order::create([
            "user_id"     => $pending->user_id,
            "total_price" => $pending->total,
            "status"      => "paid"
        ]);

        Log::info("ORDER_CREATED_SUCCESS", ["order_id" => $order->order_id]);

        // Lưu từng item
        foreach ($pending->cart as $productId => $item) {
            OrderItem::create([
                "order_id"   => $order->order_id,
                "product_id" => $productId,
                "quantity"   => $item["quantity"],
                "price"      => $item["price"]
            ]);
        }

        // XÓA pending order
        $pending->delete();

        // XOÁ GIỎ HÀNG SESSION
        session()->forget("cart");

        return "OK";
    }
}
