<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    /**
     * LIST + SEARCH + FILTER
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $ratingFilter = $request->rating ?? 'all';

        $reviews = Review::with(['product', 'user'])
            ->when($keyword, function ($q) use ($keyword) {
                $q->whereHas('product', function ($p) use ($keyword) {
                    $p->where('name', 'LIKE', "%$keyword%");
                })->orWhereHas('user', function ($u) use ($keyword) {
                    $u->where('name', 'LIKE', "%$keyword%");
                });
            })
            ->when($ratingFilter !== 'all', function ($q) use ($ratingFilter) {
                $q->where('rating', $ratingFilter);
            })
            ->orderByDesc('review_id')
            ->paginate(15)
            ->appends($request->all());

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'keyword' => $keyword,
            'ratingFilter' => $ratingFilter,
        ]);
    }

    /**
     * CREATE OR UPDATE ADMIN RESPONSE
     */
    public function addResponse(Request $request, $id)
    {
        $request->validate([
            'admin_response' => 'required|string|min:5|max:1000',
        ], [
            'admin_response.required' => 'Vui lòng nhập phản hồi',
            'admin_response.min'       => 'Phản hồi phải ít nhất 5 ký tự',
            'admin_response.max'       => 'Phản hồi không vượt quá 1000 ký tự',
        ]);

        $review = Review::findOrFail($id);

        $review->update([
            'admin_response'    => $request->admin_response,
            'admin_response_at' => now(),
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Phản hồi đã được lưu!');
    }

    /**
     * DELETE RESPONSE
     */
    public function deleteResponse($id)
    {
        $review = Review::findOrFail($id);

        $review->update([
            'admin_response'    => null,
            'admin_response_at' => null,
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Phản hồi đã được xóa!');
    }

    /**
     * DELETE REVIEW
     */
    public function delete($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Đánh giá đã được xóa!');
    }
}
