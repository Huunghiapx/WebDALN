<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = ['name', 'price', 'quantity', 'description', 'image','category_id'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items() // Giả sử bạn đã thiết lập mối quan hệ với OrderItem
    {
        return $this->hasMany(OrderItem::class);
    }
}
