<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // =============================
    // LIST REVIEWS BY PRODUCT
    // =============================
    public function listByProduct($productId)
    {
        $product = Product::findOrFail($productId);

        // Lấy review của sản phẩm, sắp xếp mới nhất trước, phân trang 10 cái/trang
        $reviews = Review::where('product_id', $productId)
            ->with('user')
            ->orderByDesc('review_id')
            ->paginate(10);

        // Tính điểm trung bình rating
        $avgRating = Review::where('product_id', $productId)->avg('rating') ?? 0;
        $totalReviews = Review::where('product_id', $productId)->count();

        // Đếm số review theo từng rating
        $ratingStats = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = Review::where('product_id', $productId)->where('rating', $i)->count();
            $ratingStats[$i] = $count;
        }

        return view('client.reviews.list', compact('product', 'reviews', 'avgRating', 'totalReviews', 'ratingStats'));
    }

    // =============================
    // CREATE REVIEW FORM
    // =============================
    public function create($productId)
    {
        $product = Product::findOrFail($productId);

        // Check xem user đã review sản phẩm này chưa
        $existingReview = Review::where('product_id', $productId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->route('reviews.list', $productId)
                ->with('warning', 'Bạn đã đánh giá sản phẩm này rồi!');
        }

        // Check xem user đã mua sản phẩm này chưa
        $hasPurchased = Order::whereHas('items', function ($q) use ($productId) {
            $q->where('product_id', $productId);
        })
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->exists();

        return view('client.reviews.create', compact('product', 'hasPurchased'));
    }

    // =============================
    // STORE REVIEW
    // =============================
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Vui lòng chọn mức đánh giá',
            'rating.min' => 'Đánh giá phải từ 1 sao trở lên',
            'rating.max' => 'Đánh giá không được vượt quá 5 sao',
            'comment.max' => 'Bình luận không được vượt quá 1000 ký tự',
        ]);

        // Check xem user đã review sản phẩm này chưa
        $existingReview = Review::where('product_id', $productId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->route('reviews.list', $productId)
                ->with('warning', 'Bạn đã đánh giá sản phẩm này rồi!');
        }

        // Tạo review mới
        Review::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'created_at' => now(),
        ]);

        return redirect()->route('reviews.list', $productId)
            ->with('success', 'Cảm ơn bạn đã đánh giá! Đánh giá của bạn sẽ được hiển thị sau khi admin xác nhận.');
    }

    // =============================
    // DELETE REVIEW (CỦA CHÍNH MÌNH)
    // =============================
    public function delete($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Chỉ cho phép xóa review của chính mình
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xóa review này!');
        }

        $productId = $review->product_id;
        $review->delete();

        return redirect()->route('reviews.list', $productId)
            ->with('success', 'Đánh giá đã được xóa!');
    }
}
