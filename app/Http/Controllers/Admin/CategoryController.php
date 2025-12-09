<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    // ============================
    // INDEX + TÌM KIẾM + PHÂN TRANG
    // ============================
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $categories = Category::when($keyword, function ($query) use ($keyword) {
                return $query->where('category_name', 'LIKE', "%$keyword%");
            })
            ->withCount('products') // 👈 THÊM DÒNG NÀY
            ->orderBy('category_id', 'DESC')
            ->paginate(10)
            ->appends($request->all());

        return view('admin.categories.index', compact('categories', 'keyword'));
    }

    // ============================
    // FORM CREATE
    // ============================
    public function create()
    {
        return view('admin.categories.create');
    }

    // ============================
    // STORE
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:100'
        ]);

        Category::create([
            'category_name' => $request->category_name
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm danh mục thành công!');
    }

    // ============================
    // EDIT FORM
    // ============================
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    // ============================
    // UPDATE
    // ============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|max:100'
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'category_name' => $request->category_name
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    // ============================
    // DELETE (kiểm tra sản phẩm trước khi xóa)
    // ============================
    public function delete($id)
    {
        // Nếu danh mục có sản phẩm → không cho xóa
        $productCount = Product::where('category_id', $id)->count();

        if ($productCount > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa! Danh mục đang có sản phẩm.');
        }

        Category::findOrFail($id)->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}
