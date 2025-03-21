<?php

namespace App\DataTables\Admin;


use App\Models\Voucher;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Column;
use App\DataTables\BuilderDatatables;


class VoucherDatatable extends BuilderDatatables
{
    protected $ajaxUrl = ['data' => 'function(d) { console.log(d);d.table = "detail"; }'];
    protected $hasCheckbox = false;
    protected $orderBy = 0;
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('code', function ($row) {
                return '
                    <a href="" data-id="'.$row->id.'" onclick="detailVoucher(this)">'.$row->code.'</a>
                    <div class="row-options">
                        <a href="#" data-id="'.$row->id.'" onclick="detailVoucher(this)">Sửa</a> |
                        <a href="#" data-id="'.$row->id.'" onclick="dialogConfirmWithAjax(deleteVoucher, this)" class="text-danger">Xóa</a>
                    </div>
                ';
            })
            ->editColumn('checkbox', function ($row) {
                return '<div class="checkbox"><input type="checkbox" value="' . $row->event_id . '"><label></label></div>';
            })
            ->editColumn('discount', function ($row) {
                return number_format($row->discount, 0, ',', '.') . 'đ';
            })

            ->editColumn('status', function ($query) {
                if ($query->status == 1) {
                    return '<span style="color: rgb(0,86,13)" class="badge border border-blue" >Active</span>';
                } else {
                    return '<span style="color: #9f3535" class="badge border border-blue" >Inactive</span>';
                }
            })
            ->editColumn('action', function ($row) {
                $s = $row->status ? 'checked' : '';
                return '
                <form>
                        <div class="onoffswitch" data-toggle="tooltip">
                        <input type="checkbox" data-id="' . $row->id . '" onclick="dialogConfirmWithAjaxchangeStatus(changeStatusVoucher, this)" class="onoffswitch-checkbox" id="' . $row->id . '" '.$s.'>
                        <label class="onoffswitch-label" for="' . $row->id . '"></label>
                        </div><span class="hide">Yes</span>
                </form>
                
                    ';
            })
            ->rawColumns(['code','action','checkbox','status']);
    }

    public function query(Voucher $model)
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
            'code' => [
                'title' => 'Mã giảm giá',
            ],
            'discount' => [
                'title' => 'Giảm giá',
            ],  
            'start_date' => [
                'title' => 'Ngày bắt đầu',
            ], 
            'end_date' => [
                'title' => 'Ngày kết thúc',
            ],  
            'usage_limit' => [
                'title' => 'Giới hạn',
            ], 
            'used_count' => [
                'title' => 'Số lần đã sử dụng',
            ],
            'status' => [
                'title' => 'Trạng thái',
            ], 
            Column::computed('action')->sortable(false)
                ->searching(false)
                ->title('Ẩn / Hiện')
                ->width('100')
                ->addClass('text-center'),
        ];
    }
}
