<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'review_id';
    public $timestamps = false; // ✅ vì bảng của bạn không có updated_at

    protected $fillable = ['product_id', 'user_id', 'rating', 'comment', 'created_at'];

    // 🔹 Mỗi review thuộc về 1 sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // 🔹 Mỗi review thuộc về 1 người dùng
    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'user_id');
}

}
