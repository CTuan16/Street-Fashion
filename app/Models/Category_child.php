<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_child extends Model
{
    use HasFactory;
    protected $table='category_child';
    protected $fillable = [
        'id_parent',    
        'name',
        'slug',

    ];
    public function category()
    {
        return $this->belongsTo(category::class, 'id_parent'); // 'id_parent' is the foreign key in 'category_child', 'id' is the primary key in 'categories'
    }public function products()
    {
        return $this->hasMany(Product::class, 'id_category_child');
    }


}
