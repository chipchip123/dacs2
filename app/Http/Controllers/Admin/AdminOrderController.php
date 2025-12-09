<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Danh sách đơn hàng
     */
    public function index(Request $request)
    {
        // Lọc theo trạng thái nếu cần
        $statusFilter = $request->input('status', 'all');

        $orders = Order::with('user')
            ->when($statusFilter !== 'all', function ($query) use ($statusFilter) {
                return $query->where('status', $statusFilter);
            })
            ->orderBy('order_id', 'DESC')
            ->paginate(10)
            ->appends($request->all());

        return view('admin.orders.index', compact('orders', 'statusFilter'));
    }


    /**
     * Chi tiết 1 đơn hàng
     */
    public function detail($id)
    {
        $order = Order::with(['user', 'items.product'])
            ->findOrFail($id);

        return view('admin.orders.detail', compact('order'));
    }


    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()
            ->route('admin.orders.detail', $id)
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }


    /**
     * Form tạo đơn hàng mới
     */
    public function create()
    {
        $users = User::all();
        $products = Product::all();

        return view('admin.orders.create', compact('users', 'products'));
    }


    /**
     * Lưu đơn hàng mới (Admin tự tạo đơn)
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'products'  => 'required|array',
            'quantities'=> 'required|array'
        ]);

        // Tính tổng tiền
        $total = 0;
        foreach ($request->products as $index => $productId) {
            $product = Product::find($productId);
            $qty = $request->quantities[$index];

            if ($product && $qty > 0) {
                $total += $product->price * $qty;
            }
        }

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $request->user_id,
            'total_price' => $total,
            'status' => 'pending'
        ]);

        // Lưu từng sản phẩm trong đơn
        foreach ($request->products as $index => $productId) {
            $product = Product::find($productId);
            $qty = $request->quantities[$index];

            if ($product && $qty > 0) {
                OrderItem::create([
                    'order_id'  => $order->order_id,
                    'product_id'=> $productId,
                    'quantity'  => $qty,
                    'price'     => $product->price
                ]);
            }
        }

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Tạo đơn hàng thành công!');
    }
}
