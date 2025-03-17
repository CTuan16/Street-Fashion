<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $fillable = [
        'name',
        'description',
        'id_category_parent',
        'id_category_child',
        'slug',
        'primary_image',
        'second_image',
        'quantity_favorite',
        'rate'
    ];

    // Mối quan hệ với ProductMeta
    public function product_meta()
    {
        return $this->hasMany(ProductMeta::class, 'id_product');
    }
    public function productcolor()
    {
        return $this->hasMany(ProductColor::class, 'id_product');
    }
    public function productsize()
    {
        return $this->hasMany(ProductSize::class, 'id_product');
    }
   
    public function category()
    {
        return $this->belongsTo(category::class, 'id_category_parent'); // Hoặc 'id_category_child' tùy thuộc vào cấu trúc của bạn
    }
    public function categorychild()
    {
        return $this->belongsTo(Category_child::class, 'id_category_child'); // Hoặc 'id_category_child' tùy thuộc vào cấu trúc của bạn
    }
    public function favorite_product()
    {
        return $this->hasMany(favorite_product::class,'id_product');
    }
    public function start()
    {
        return $this->hasMany(start::class,'id_product');
    }
    //rating
    public function rating()
    {
        return $this->hasMany(ratingModel::class,'id_product');
    }
    
        public function favorites()
    {
        return $this->hasMany(favorite_product::class, 'id_product');
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }
    
    }
