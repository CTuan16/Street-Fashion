<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMeta extends Model
{
    protected $table = 'product_meta';
    protected $fillable = [
        'id_product',
        'quantity',
        'sold',
        'price',
        'price_sale',
        'default',
        'product_sale'
    ];

    use HasFactory;
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product'); // Liên kết đến bảng product
    }
    public function Color()
    {
        return $this->belongsTo(color::class, 'id_product_meta ');
    }

    public function Size()
    {
        return $this->belongsTo(size::class, 'id_product_meta ');
    }

    // Thêm mutator để đảm bảo giá trị product_sale luôn là integer
    public function setProductSaleAttribute($value)
    {
        $this->attributes['product_sale'] = (int) $value;
    }
}