<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductClientController extends Controller
{
    public function product(Request $request, $category_id = null)
    {
        $query = Product::query();

        // === 1. Load reviews data (rating, count) ===
        $query->withAvg('reviews', 'rating')
            ->withCount('reviews');

        // === 2. Lọc theo danh mục ===
        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        // === 2. Lọc theo tên sản phẩm ===
        if ($request->search_name) {
            $query->where('name', 'LIKE', '%' . $request->search_name . '%');
        }

        // === 3. Lọc theo giá ===
        switch ($request->price_filter) {
            case 'under-100k':
                $query->where('price', '<', 100000);
                break;

            case 'under-200k':
                $query->where('price', '<', 200000);
                break;

            case 'under-300k':
                $query->where('price', '<', 300000);
                break;

            case 'above-300k':
                $query->where('price', '>=', 300000);
                break;
        }

        // === 4. SORT PRO ===
        switch ($request->sort_by) {

            case 'price-asc':
                $query->orderBy('price', 'ASC');
                break;

            case 'price-desc':
                $query->orderBy('price', 'DESC');
                break;

            case 'name-asc':
                $query->orderBy('name', 'ASC');
                break;

            case 'name-desc':
                $query->orderBy('name', 'DESC');
                break;

            case 'sold-desc':
                $query->orderBy('sold', 'DESC');
                break;

            case 'newest':
                $query->orderBy('created_at', 'DESC');
                break;

            case 'oldest':
                $query->orderBy('created_at', 'ASC');
                break;

            case 'top-rated':
                // cần bảng reviews
                $query->withAvg('reviews', 'rating')
                    ->orderBy('reviews_avg_rating', 'DESC');
                break;
        }

        // === 5. Phân trang ===
        $products = $query->paginate(9, ['*'], 'page', 1)->appends($request->query());

        return view('client.product', [
            'products' => $products,
            'priceFilter' => $request->price_filter,
            'sortBy' => $request->sort_by,
        ]);
    }
}
