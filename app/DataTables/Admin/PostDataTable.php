<?php

namespace App\DataTables\Admin;

use App\Models\Post;
use App\DataTables\BuilderDatatables;

class PostDataTable extends BuilderDatatables
{
    protected $ajaxUrl = ['data' => 'function(d) { d.table = "detail"; }'];
    protected $hasCheckbox = false;
    protected $orderBy = 0;

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('title', function ($row) {
                return '
                    <a href="' . route('post.edit', $row->id) . '">' . $row->title . '</a>
                    <div class="row-options">
                        <a href="' . route('post.edit', $row->id) . '">Sửa</a> |
                        <a href="#" data-id="' . $row->id . '" onclick="dialogConfirmWithAjax(deletePost, this)" class="text-danger">Xóa</a>
                    </div>
                ';
            })
            ->editColumn('content', function ($row) {
                return \Str::limit(strip_tags($row->content), 100);
            })
            ->editColumn('image', function ($row) {
                if ($row->image) {
                    return '<img src="' . asset($row->image) . '" alt="" width="50" height="50">';
                } else {
                    return 'Không có ảnh';
                }
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->format('d/m/Y H:i:s');
            })
            ->rawColumns(['image', 'title']);
    }

    public function query(Post $model)
    {
        return $model->newQuery();
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => 'ID',
                'width' => '20px',
            ],
            'title' => [
                'title' => 'Tiêu đề',
            ],
            'content' => [
                'title' => 'Nội dung',
            ],
            'image' => [
                'title' => 'Hình ảnh',
            ],
            'created_at' => [
                'title' => 'Ngày tạo',
            ],
            'updated_at' => [
                'title' => 'Ngày cập nhật',
            ]
        ];
    }
}
