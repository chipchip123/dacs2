<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\User;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'total_price',
        'status'
    ];
    protected $casts = [
    'status' => 'string',
];


    // Danh sách sản phẩm trong đơn
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    // Người đặt hàng
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
