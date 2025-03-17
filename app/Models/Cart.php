<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Quan hệ với sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Quan hệ với người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
