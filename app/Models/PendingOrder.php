<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingOrder extends Model
{
    protected $table = "pending_orders";

    protected $fillable = [
        'user_id',
        'cart',
        'total',
        'code',
    ];

    protected $casts = [
        'cart' => 'array'
    ];
}
