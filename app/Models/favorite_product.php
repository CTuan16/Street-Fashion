<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favorite_product extends Model
{
    use HasFactory;
    protected $table = 'favorite_product';
 
    protected $fillable = [
        'id_user', // Thêm các trường này để cho phép mass assignment
        'id_product',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'id_product');
    }
}
