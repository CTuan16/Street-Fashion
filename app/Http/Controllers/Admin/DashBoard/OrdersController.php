<?php

namespace App\Http\Controllers\Admin\DashBoard;


use App\Models\Order;
use App\Models\Status;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\DataTables\Admin\OrdersDataTable;
use App\Http\Controllers\Admin\BaseController;


class OrdersController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->title = 'Danh sách đơn hàng';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrdersDataTable $dataTable, Request $request)
    {
       
        $list_status = Status::where('type','order')->get();

        $data = ['list_status' => $list_status];


        return $dataTable->render('admin.orders.index', ['data'=> $data]);
    }

    
    
    public function show(Request $request)
    {
        $data = Order::findOrFail($request->id);
        $status_code = $data->order_status_id !== 11;  // Nếu không phải Processing, hiển thị trạng thái hủy

        return response(['data' => $data ,
        
    ]);
    }

    public function update(Request $request, $id)
{
    $order = Order::findOrFail($request->id);
    
    // Nếu trạng thái đơn hàng là 12(Hoàn tất)
    if($request->order_status_id === "12") {
        $order->payment->payment_status = 'Đã thanh toán';
        $order->payment->save();
    }
    
    // Nếu trạng thái đơn hàng là 13 ("Đã hủy")
    if($request->order_status_id === "13") {
        if($order->payment->payment_status === 'Đã thanh toán') {
            $order->payment->payment_status = 'Đã hoàn tiền';
            $order->payment->save();
        } elseif($order->payment->payment_status === 'Thanh toán thất bại') {
            $order->order_status_id = 13;
        }
    }
    
    $order->update($request->all());
    $this->addToLog($request);
    return response(['success' => 'success', 'message'=> 'Cập nhật thành công!']);
}

    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_status_id' => 'required|exists:order_status,id',
        ]);
    
        $order = Order::find($request->order_id);
        $order->order_status_id = $request->order_status_id;

        $order->save();
        
      
    
        return response()->json(['message' => 'Cập nhật trạng thái thành công.']);
    }

    public function view($order_id)
    {
        // Lấy thông tin đơn hàng theo order_id
        $order = Order::with(['orderDetails', 'user', 'orderStatus', 'payment', 'voucher'])->findOrFail($order_id);
        
        // Trả về view chi tiết đơn hàng
        return view('admin.orders.view', compact('order'));
    }



public function updatePaymentStatus(Request $request)
    {
        
        $request->validate([
            'row_id' => 'required|integer',
            'status_id' => 'required'
        ]);
        $rowId = (int) $request->row_id;
        $payment = Payment::find($rowId);
        if (!$payment) {
            return response()->json(['error' => 'Không tìm thấy thông tin thanh toán'], 404);
        }
    
        // Cập nhật trạng thái
        $payment->payment_status = $request->status_id;
        $payment->save();
    
        return response()->json(['success' => 'Cập nhật trạng thái thành công']);
    }

}


