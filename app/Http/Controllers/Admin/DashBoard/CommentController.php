<?php

namespace App\Http\Controllers\Admin\DashBoard;

use App\Models\Comment;
use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\Admin\CommentDataTable;
use App\Http\Controllers\Admin\BaseController;


class CommentController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->title = 'Danh sách bình luận';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommentDataTable $dataTable)
    {   
        return $dataTable->render('admin.comment.index');
    }

    public function show(Request $request)
{
    $comment = Comment::findOrFail($request->id);
    $product = product::find($comment->product_id);
    $user = User::find($comment->user_id);

    return response()->json([
        'comment' => $comment,
        'user_name' => $user ? $user->name:'',  
        'product_name' => $product ? $product->name : null,
        'rating' => $comment->rating,
        'content' => $comment->content,
    ]);
}

    
    public function destroy(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        $comment->delete();
        $this->addToLog(request());
        return response()->json(['message' => 'Xóa thành công!']);
    }
    public function changeStatus(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        $comment->status == 0 ? $comment->status =1 : $comment->status = 0;
        $comment->save();
        $this->addToLog(request());
        return response()->json(['message' => 'Thay đổi thành công!']);
    }
}
