<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Review;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

    // Vì bảng có created_at và updated_at → để true
    public $timestamps = true;

    // Các cột được phép thêm/sửa
    protected $fillable = [
        'name',
        'price',
        'image',
        'sold',
        'category_id',
        'description',
    ];

    /**
     * ⭐ Quan hệ: 1 sản phẩm thuộc 1 danh mục
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * ⭐ Quan hệ: 1 sản phẩm có nhiều review
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'product_id');
    }

    /**
     * ⭐ Tính trung bình số sao
     */
    public function avgRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * ⭐ Đếm số lượng đánh giá
     */
    public function totalReviews()
    {
        return $this->reviews()->count();
    }

    /**
     * ⭐ Format giá (option: dùng trong blade)
     */
    public function formatPrice()
    {
        return number_format($this->price, 0, ',', '.') . ' đ';
    }
}
