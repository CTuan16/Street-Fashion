<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchKeyword extends Model
{
    use HasFactory;

    // Định nghĩa bảng tương ứng
    protected $table = 'search_keyword';

    // Các cột mà bạn có thể gán giá trị mass assignment
    protected $fillable = [
        'keyword',
        'count' // Cột keyword
    ];


}
