<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Status;


use Illuminate\Support\Facades\Auth;

class ShowOrderController extends Controller
{
    public function showOrder()
    {
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)
            ->with(['orderStatus', 'orderDetails.product.productsize.size', 'orderDetails.product.productcolor.color'])
            ->orderBy('created_at', 'desc')
            ->get();

        $orderStatuses = Status::where('type', 'order')->get();

        return view('client.cart.purchase_history', [
            'orders' => $orders,
            'orderStatuses' => $orderStatuses
        ]);
    }

    public function cancelOrder($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        // Kiểm tra nếu đơn hàng đang ở trạng thái chờ xử lý (ID = 9)
        if ($order->order_status_id == 9) { 
            // Cập nhật trạng thái sang đã hủy (ID = 13) 
            $order->order_status_id = 13;
            $order->save();
            
            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công!');
        }
        
        return redirect()->back()->with('error', 'Không thể hủy đơn hàng này!');
    }
}