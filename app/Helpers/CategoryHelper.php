<?php

namespace App\Helpers;

use App\Models\Category;

class CategoryHelper
{
    public static function getAll()
    {
        return Category::orderBy('category_id')->get(); // lấy theo thứ tự id
    }
}
