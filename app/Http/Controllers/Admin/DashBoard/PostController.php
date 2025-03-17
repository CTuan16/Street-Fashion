<?php

namespace App\Http\Controllers\Admin\DashBoard;

use App\Models\Post;
use Illuminate\Http\Request;
use App\DataTables\Admin\PostDataTable;
use App\Http\Controllers\Admin\BaseController;

class PostController extends BaseController
{
    public $model;
    
    public function __construct()
    {
        parent::__construct();
        $this->title = 'Quản lý bài viết';
        $this->model = new Post();
    }

    public function index(PostDataTable $dataTable)
    {
        return $dataTable->render('admin.post.index');
    }

    public function create()
    {
        $post = new Post();
        return view('admin.post.create', compact('post'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'path_1.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->hasFile('path_1')) {
            foreach ($request->file('path_1') as $image) {
                \Log::info('Uploading image:', ['name' => $image->getClientOriginalName()]);
                
                $filename = hash('sha256', time() . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
                
                $path = $image->storeAs('upload/posts', $filename, 'public');
                $dbPath = '/storage/' . $path;
                
                $post->image = $dbPath;
                break;
            }
        }

        \Log::info('Post data before save:', $post->toArray());

        $post->save();

        return redirect()->route('post.index')->with(['status' => 'success', 'html' => 'Thành công']);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string ',
            'path_1.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->hasFile('path_1')) {
            foreach ($request->file('path_1') as $image) {
                $filename = hash('sha256', time() . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
                
                $path = $image->storeAs('upload/posts', $filename, 'public');
                $dbPath = '/storage/' . $path;
                
                $post->image = $dbPath;
                break;
            }
        }

        $post->save();

        return redirect()->route('post.index')->with(['status' => 'success', 'html' => 'Thành công']);
    }

    public function destroy(Request $request)
    {
        $post = Post::findOrFail($request->id);
        
        if ($post->image && file_exists(public_path($post->image))) {
            unlink(public_path($post->image));
        }

        $post->delete();

        return response()->json(['message' => 'Xóa thành công!']);
    }
}
