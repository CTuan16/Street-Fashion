<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class color extends Model
{
    protected $table = 'color';

    protected $fillable = [
        'id',
        'name_color',
        
    ];

    use HasFactory;
    public function product()
    {
        return $this->belongsToMany(Product::class, 'id_product');
    }
  
    
}