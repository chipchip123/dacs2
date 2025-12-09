<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;


class ClientController extends Controller
{
    public function index()
    {
        // Lấy 7 sản phẩm bán chạy nhất kèm review
        $hotProducts = Product::with('reviews')
            ->orderByDesc('sold')
            ->take(7)
            ->get();
        $newProducts = Product::with('reviews')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderByDesc('created_at')
            ->take(10)
            ->get();
        $commentReviews = Product::withCount('reviews')  // đếm số lượng review
            ->orderByDesc('reviews_count')               // sắp xếp theo số lượng review giảm dần
            ->with('reviews.user')                       // nếu muốn load luôn người review
            ->take(9)                                   // lấy 9 sản phẩm đầu
            ->get();
        return view('client.index', compact('hotProducts', 'newProducts', 'commentReviews'));
    }

}
