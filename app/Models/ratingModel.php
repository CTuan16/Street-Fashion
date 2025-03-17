<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ratingModel extends Model
{
    use HasFactory;
    protected $table = 'ratings';
    protected $fillable = ['id_product', 'id_user', 'rating', 'review'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
