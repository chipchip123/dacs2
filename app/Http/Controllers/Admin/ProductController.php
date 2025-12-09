<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // =============================
    // LIST + SEARCH + FILTER + PAGINATE
    // =============================
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $categoryFilter = $request->category ?? 'all';

        $products = Product::join('categories', 'products.category_id', '=', 'categories.category_id')
            ->select('products.*', 'categories.category_name')
            ->when($keyword, fn($q) =>
                $q->where('products.name', 'LIKE', "%$keyword%")
            )
            ->when($categoryFilter !== 'all', fn($q) =>
                $q->where('products.category_id', $categoryFilter)
            )
            ->orderByDesc('products.product_id')
            ->paginate(10)
            ->appends($request->all());

        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories', 'keyword', 'categoryFilter'));
    }

    // =============================
    // CREATE FORM
    // =============================
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // =============================
    // STORE PRODUCT
    // =============================
    public function store(Request $request)
    {
        $imageName = null;

        if ($request->hasFile('image')) {
            $originalName = $request->image->getClientOriginalName();
            $imageName = $this->makeUniqueFileName($originalName);

            $request->image->move(public_path('images/products'), $imageName);
        }

        Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'image'       => $imageName,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    // =============================
    // EDIT FORM
    // =============================
    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    // =============================
    // UPDATE PRODUCT
    // =============================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {

            // XÓA ẢNH CŨ
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }

            // Lấy tên gốc + chống trùng
            $originalName = $request->image->getClientOriginalName();
            $imageName = $this->makeUniqueFileName($originalName);

            $request->image->move(public_path('images/products'), $imageName);

            $product->image = $imageName;
        }

        $product->name        = $request->name;
        $product->price       = $request->price;
        $product->category_id = $request->category_id;

        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // =============================
    // DELETE PRODUCT
    // =============================
    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Xóa ảnh luôn
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công!');
    }

    // =============================
    // MAKE UNIQUE FILE NAME
    // =============================
    private function makeUniqueFileName($originalName)
    {
        $path = public_path('images/products/');
        $name = pathinfo($originalName, PATHINFO_FILENAME);
        $ext  = pathinfo($originalName, PATHINFO_EXTENSION);

        $newName = $originalName;
        $i = 1;

        while (file_exists($path . $newName)) {
            $newName = $name . '-' . $i . '.' . $ext;
            $i++;
        }

        return $newName;
    }
}
