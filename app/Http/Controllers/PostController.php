<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SearchKeyword;
class PostController extends Controller
{
    public function showPost()
    {
        $posts = Post::all();
        $popularKeywords = SearchKeyword::orderBy('count', 'desc')->take(7)->get();
        return view('client.selection', compact('posts','popularKeywords'));
    }

  
    
        // Lấy danh mục
        
}