<?php

namespace App\DataTables\Admin;

use App\Models\Order;
use App\Models\Status;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use App\DataTables\BuilderDatatables;

class OrdersDataTable extends BuilderDatatables
{
    // protected $ajaxUrl = ['data' => 'function(d) { console.log(d);d.table = "detail"; }'];
    // protected $hasCheckbox = false;
    // protected $orderBy = 0;
    // <a href="'.route('admin.orders.detail',['id' => $row->id]).'">'.$row->order_code.'</a>
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            
            ->editColumn('order_code', function ($row) {
                if($row->order_status_id == 12) {
                    return  '<a href="'.route('orders.view',['id' => $row->id]).'">'.$row->order_code.'</a> ';
                }
                return '
                     <a href="'.route('orders.view',['id' => $row->id]).'">'.$row->order_code.'</a>
                    <div class="row-options">
                        <a href="#" data-id="'.$row->id.'" onclick="detailOrder(this)">Sửa</a>
                    </div>
                ';
            })
            
            ->editColumn('user_id', function ($row) {
                return $row->user->name ?? 'N/A';
            })
            ->editColumn('order_status_id', function ($row) {
                // Lấy danh sách các trạng thái với `type = 'order'`
                $statuses = Status::where('type', 'order')->get();
            
                // Tạo các tùy chọn với màu sắc tùy thuộc vào status_id
                $statusHtml = '';
                foreach ($statuses as $status) {
                    // Kiểm tra trạng thái để áp dụng màu sắc
                    if ($row->order_status_id == $status->id) {
                        // Gán màu sắc cho từng trạng thái
                        $color = ''; // Màu mặc định
                        switch ($status->id) {
                            case 9:
                                $color = 'background-color: #FFF8E5; color: black; border: 2px solid #FFD700;'; // Màu vàng nhạt, viền vàng
                                break;
                            case 11:
                                $color = 'background-color: #F0F9FE; color: black; border: 2px solid #00BFFF;'; // Màu xanh nhạt, viền xanh
                                break;
                            case 12:
                                $color = 'background-color: #E7FFF2; color: black; border: 2px solid #32CD32;'; // Màu xanh lá nhạt, viền xanh lá
                                break;
                            case 13:
                                $color = 'background-color: #FF99A5; color: black; border: 2px solid #FF69B4;'; // Màu hồng nhạt, viền hồng
                                break;
                            default:
                                $color = 'background-color: black; color: white; border: 2px solid #FFFFFF;'; // Màu mặc định, viền trắng
                                break;
                        }
                        
                        // Tạo HTML để hiển thị tên trạng thái với màu sắc và border
                        $statusHtml = "<span style='$color padding: 5px; border-radius: 4px;'>{$status->status_name}</span>";
                    } 
                }
            
                // Trả về HTML hiển thị trạng thái với màu sắc và border
                return $statusHtml;
            })

            ->editColumn('payment_id', function ($row) {
                // Kiểm tra xem payment có tồn tại không
                if (!$row->payment) {
                    return 'N/A';
                }
            
                // Lấy tất cả các trạng thái thanh toán
                $statuses = Status::where('type', 'payment')->pluck('status_name', 'id');
                $status_code = $row->payment->payment_status;
            
                // Danh sách các trạng thái cần disabled
                $disabledStatuses = [
                    'Đã thanh toán',
                    'Thanh toán thất bại',
                    'Đã hoàn tiền'
                ];
            
                // Kiểm tra nếu trạng thái nằm trong danh sách cần disabled
                $disabled = in_array($status_code, $disabledStatuses) ? 'disabled' : '';
            
                // Tạo thẻ select với các options
                $select = '<select class="form-control status-dropdown" data-id="' . $row->payment_id . '" data-current-status="' . $status_code . '" ' . $disabled . '>';
                foreach ($statuses as $id => $name) {
                    $selected = $name == $status_code ? 'selected' : '';
                    $select .= "<option value='{$name}' {$selected}>{$name}</option>";
                }
                $select .= '</select>';
            
                return $select;
            })
            
            ->editColumn('checkbox', function ($row) {
                return '<div class="checkbox"><input type="checkbox" value="' . $row->event_id . '"><label></label></div>';
            })
            ->editColumn('total_amount', function ($row) {
                return number_format($row->total_amount, 0, ',', '.') . 'đ';
            })
            ->editColumn('voucher_id', function ($row) {
                if ($row->voucher) {
                    return $row->voucher->code . ' (' . number_format($row->voucher->discount, 0, ',', '.') . 'đ)';
                }
                return 'Không có';
            })
            
            ->rawColumns(['order_code','checkbox','user_id','order_status_id','payment_id','total_amount','voucher_id']);
    }

    public function query(Order $model)
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
            'order_code' => [
                'title' => 'Mã đơn hàng',
            ],
            'user_id' => [
                'title' => 'Người mua',
            ],
            'order_status_id' => [
                'title' => 'Trạng thái',
            ],
            'payment_id' => [
                'title' => 'Trang thái thanh toán',
            ],
            'voucher_id' => [
                'title' => 'Mã giảm giá',
            ],
            'total_amount' => [
                'title' => 'Tổng đơn',
            ],
        ];
    }
}
