<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class size extends Model
{
    protected $table = 'size';

    protected $fillable = [
        'id',
        'name_size',
        
    ]; 

    use HasFactory;
    public function product()
    {
        return $this->belongsToMany(Product::class, 'id_product');
    }
}