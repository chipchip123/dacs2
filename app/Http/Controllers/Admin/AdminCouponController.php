<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;

class AdminCouponController extends Controller
{
    /**
     * Danh sách coupon + tìm kiếm + lọc + auto disable coupon hết hạn
     */
    public function index(Request $request)
    {
        // ❗ Tự động vô hiệu hóa coupon khi hết hạn
        Coupon::where('expires_at', '<', Carbon::now())
              ->where('active', 1)
              ->update(['active' => 0]);

        $keyword = $request->keyword;
        $status  = $request->status;

        $coupons = Coupon::when($keyword, function ($query) use ($keyword) {
                    return $query->where('code', 'LIKE', "%$keyword%");
                })
                ->when($status, function ($query) use ($status) {
                    if ($status === 'active') {
                        return $query->where('active', 1);
                    }
                    if ($status === 'expired') {
                        return $query->where('active', 0);
                    }
                })
                ->orderBy('id', 'DESC')
                ->paginate(10)
                ->appends($request->all());

        return view('admin.coupons.index', compact('coupons', 'keyword', 'status'));
    }



    /**
     * Form thêm coupon mới
     */
    public function create()
    {
        return view('admin.coupons.create');
    }



    /**
     * Lưu coupon mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'           => 'required|unique:coupons,code',
            'discount_value' => 'required|numeric|min:1',
            'max_discount'   => 'required|numeric|min:0',
            'expires_at'     => 'required|date',
        ]);

        Coupon::create([
            'code'           => strtoupper($request->code),
            'discount_value' => $request->discount_value,
            'max_discount'   => $request->max_discount,
            'expires_at'     => $request->expires_at,
            'active'         => 1,
        ]);

        return redirect()->route('admin.coupons.index')
                         ->with('success', 'Thêm mã giảm giá thành công!');
    }



    /**
     * Form sửa coupon
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }



    /**
     * Cập nhật coupon
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code'           => "required|unique:coupons,code,$id,id",
            'discount_value' => 'required|numeric|min:1',
            'max_discount'   => 'required|numeric|min:0',
            'expires_at'     => 'required|date',
            'active'         => 'required|in:0,1',
        ]);

        $coupon->update([
            'code'           => strtoupper($request->code),
            'discount_value' => $request->discount_value,
            'max_discount'   => $request->max_discount,
            'expires_at'     => $request->expires_at,
            'active'         => $request->active,
        ]);

        return redirect()->route('admin.coupons.index')
                         ->with('success', 'Cập nhật mã giảm giá thành công!');
    }



    /**
     * Xóa coupon
     */
    public function delete($id)
    {
        Coupon::findOrFail($id)->delete();

        return redirect()->route('admin.coupons.index')
                         ->with('success', 'Xóa mã giảm giá thành công!');
    }
}
