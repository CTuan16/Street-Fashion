<?php

namespace App\DataTables\Admin;


use App\Models\category;
use App\DataTables\BuilderDatatables;
use App\Models\Category_child;

class CategoryChildDabaTable extends BuilderDatatables
{
    protected $ajaxUrl = ['data' => 'function(d) { console.log(d);d.table = "detail"; }'];
    protected $hasCheckbox = false;
    protected $orderBy = 0;
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('name', function ($row) {
                return '
                    <a href="#" data-id="'.$row->id.'" onclick="detailCategoryChild(this)">'.$row->name.'</a>
                    <div class="row-options">
                        <a href="#" data-id="'.$row->id.'" onclick="detailCategoryChild(this)">Sửa</a> |
                        <a href="#" data-id="'.$row->id.'" onclick="dialogConfirmWithAjax(deleteCategoryChild, this)" class="text-danger">Xóa</a>
                    </div>
                ';
            })
            ->editColumn('id_parent', function ($row) {
                return $row->category->name ?? 'N/A';
            })
            ->rawColumns(['name', 'id_parent', ]);
            ;
            
    }

    public function query(Category_child $model)
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
            'name' => [
                'title' => 'Tên',
            ],
        
            'id_parent' => [
                'title' => 'Danh mục cha',
            ],
        ];
    }
}
