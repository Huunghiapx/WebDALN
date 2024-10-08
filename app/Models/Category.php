<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tên bảng tương ứng trong database
    protected $table = 'categories';

    // Các thuộc tính có thể được mass-assign (gán đồng loạt)
    protected $fillable = ['id', 'name'];

    // Thiết lập quan hệ với model Product
    public function products()
    {
        return $this->hasMany(Product::class); // Một category có nhiều sản phẩm
    }
}
