<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table = 'product_size';

    protected $fillable = [
        'id',
        'id_product',
        'size_id',
        
    ]; 

    use HasFactory;
    public function product()
    {
        return $this->belongsToMany(Product::class, 'id_product');
    }

    public function size()
    {
        return $this->belongsTo(size::class, 'size_id');
    }

}