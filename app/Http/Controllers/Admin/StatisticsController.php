<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        // ============================
        // DOANH THU THEO 12 THÁNG
        // ============================
        $revenueByMonth = Order::select(
                DB::raw('MONTH(created_at) AS month'),
                DB::raw('SUM(total_price) AS revenue')
            )
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('revenue', 'month');

        // Tạo mảng 12 tháng (nếu tháng nào không có doanh thu thì trả 0)
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRevenue[$i] = $revenueByMonth[$i] ?? 0;
        }

        // ============================
        // DOANH THU 7 NGÀY
        // ============================
        $last7Days = Order::select(
                DB::raw('DATE(created_at) AS date'),
                DB::raw('SUM(total_price) AS revenue')
            )
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ============================
        // TRẠNG THÁI ĐƠN HÀNG (Pie Chart)
        // ============================
        $orderStatus = Order::select('status', DB::raw('COUNT(*) AS total'))
            ->groupBy('status')
            ->get();

        // ============================
        // TOP 5 SẢN PHẨM BÁN CHẠY
        // ============================
        $topProducts = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) AS total_sold')
            )
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.statistics.index', compact(
            'monthlyRevenue',
            'last7Days',
            'orderStatus',
            'topProducts'
        ));
    }
}
