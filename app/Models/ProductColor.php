<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductColor extends Model
{
    use HasFactory;
    protected $table = 'product_color';
    protected $fillable = [
        'id',
        'id_product',
        'color_id',
        
    ];

    
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
    public function color()
    {
        return $this->belongsTo(color::class, 'color_id');
    }


}