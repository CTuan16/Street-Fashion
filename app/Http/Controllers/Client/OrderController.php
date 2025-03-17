<?php

namespace App\Http\Controllers\Client;

use Exception;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Voucher;
use App\Models\HistoryTransaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;

use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|digits_between:9,15',
                'email' => 'required|email',
                'address' => 'required|string|max:500',
                'payment_method' => 'required|string|in:COD,BANK',
            ]);

            // Thêm số điện thoại vào địa chỉ
            $fullAddress = sprintf(
                '%s, %s, %s, %s, %s',
                $validatedData['phone'],
                $validatedData['address'],
                $request['ward'],
                $request['district'], 
                $request['province']
            );

            // Lấy thông tin giỏ hàng từ session
            $userId = auth()->id();
            $cart = session()->get('cart.' . $userId, []);

            if (empty($cart)) {
                return redirect()->back()->withErrors(['message' => 'Giỏ hàng của bạn đang trống.']);
            }

            // Tính tổng tiền ban đầu từ giỏ hàng
            $totalAmount = 0;
            $orderCode = 'ORD' . strtoupper(Str::random(8));
            
            // Tạo và lưu order trước
            $order = new Order();
            $order->user_id = $userId;
            $order->address = $fullAddress;
            $order->order_status_id = 9;
            $order->order_code = $orderCode;
            $order->total_amount = 0; // Sẽ cập nhật sau
            $order->save(); // Lưu order để có order_id

            // Sau đó mới tạo order details
            foreach ($cart as $item) {
                $totalPrice = $item['price'] * $item['quantity'];
                $orderDetail = $order->orderDetails()->create([
                    'product_id' => $item['id'],
                     'color' => $item['color'],
                    'size' => $item['size'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $totalPrice,
                ]);
                $totalAmount += $totalPrice;
            }

            // Cộng phí ship vào tổng tiền một cách ngắn gọn
            $totalAmount += setting('fee_ship');

            // Xử lý voucher
            $voucherCode = $request->input('voucher_id');
            if ($voucherCode) {
                $voucher = Voucher::where('code', $voucherCode)
                    ->where('usage_limit', '>', 0)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->first();

                if ($voucher) {
                    // Kiểm tra xem người dùng đã sử dụng voucher này chưa
                    $hasUsedVoucher = Order::where('user_id', $userId)
                        ->where('voucher_id', $voucher->id)
                        ->exists();

                    if (!$hasUsedVoucher) {
                        $order->voucher_id = $voucher->id;
                        $discount = min($voucher->discount, $totalAmount);
                        $totalAmount -= $discount;

                        // Giảm số lượt sử dụng của voucher
                        $voucher->decrement('usage_limit');
                    }
                }
            }

            // Cập nhật tổng tiền cuối cùng
            $order->total_amount = $totalAmount;
            $order->save();

            // Xóa giỏ hàng sau khi đặt hàng
            session()->forget('cart.' . $userId);

            if ($request->payment_method === 'COD') {
                // Nếu phương thức thanh toán là COD
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $totalAmount, // Tổng tiền đơn hàng
                    'payment_method' => $request->payment_method,
                    'payment_status' => payment_status('pending')
                ]);
            } else {

                $accountNo = '1527161408'; // Số tài khoản
                $acqId = '970422'; // Mã ngân hàng
                $accountName = urlencode('HUYNH HAN CONG TUAN'); // Tên tài khoản
                $amount = $totalAmount; // Tổng tiền
                $addInfo = $order->order_code; // Nội dung (mã đơn hàng)

                // Tạo URL QR code
                $qrUrl = "https://api.vietqr.io/image/{$acqId}-{$accountNo}-5mDSHQa.jpg?accountName={$accountName}&amount={$amount}&addInfo={$addInfo}";

                // Lưu thông tin thanh toán
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $totalAmount,
                    'payment_method' => $request->payment_method,
                    'order_code' => $orderCode, // Lưu mã đơn hàng
                    'payment_status' => payment_status('pending'), // Trạng thái mặc định là 'pending'

                ]);
                $order->update(['payment_id' => $payment->id]);

                // Trả về view với mã QR
                return view('client.cart.qr_code', compact('qrUrl', 'order'));
            }

            // Cập nhật thông tin thanh toán vào đơn hàng
            $order->update(['payment_id' => $payment->id]);

            return view('client.cart.order_successfully', compact('order'));
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xác thực.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Order creation failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function generateQR(Request $request)
    {
        $order = Order::where('order_code', $request->order_code)->first();
        // Lấy thông tin từ request
        $accountNo = '1527161408'; // Số tài khoản
        $acqId = '970422'; // Mã ngân hàng
        $accountName = urlencode('HUYNH HAN CONG TUAN'); // Tên tài khoản (URL encode để đảm bảo an toàn)
        $amount = $order->total_amount;

        $addInfo = $order->order_code; // Nội dung mô tả (order_code)

        // Tạo URL dựa trên các tham số đã cung cấp
        $qrUrl = "https://api.vietqr.io/image/{$acqId}-{$accountNo}-5mDSHQa.jpg?accountName={$accountName}&amount={$amount}&addInfo={$addInfo}";

        return response()->json([
            'status' => 'success',
            'qrUrl' => $qrUrl,
        ]);
    }

    public function qr(Request $request)
    {
        // Lấy thông tin từ request
        $accountNo = '1527161408'; // Số tài khoản
        $acqId = '970422'; // Mã ngân hàng
        $accountName = urlencode('HUYNH HAN CONG TUAN'); // Tên tài khoản (URL encode để đảm bảo an toàn)
        $amount = '2000';

        $addInfo = 'ORD-JGHDFG-728734'; // Nội dung mô tả (order_code)

        // Tạo URL dựa trên các tham số đã cung cấp
        $qrUrl = "https://api.vietqr.io/image/{$acqId}-{$accountNo}-5mDSHQa.jpg?accountName={$accountName}&amount={$amount}&addInfo={$addInfo}";

       
        return view("client.cart.qr_code", compact("qrUrl"));
    }

    public function thueapi_hooks(Request $request)
{
    try {
        // Lấy nội dung từ request
        $content = $request->content;
        
        // Tìm kiếm mã đơn hàng bắt đầu bằng "ORD" trong content
        preg_match('/-(ORD[a-zA-Z0-9]+)-/', $content, $matches);

        // Kiểm tra nếu tìm thấy mã đơn hàng hợp lệ
        if (empty($matches)) {
            return response()->json(['error' => 'Mã đơn hàng không hợp lệ.'], 400);
        }

        // Lấy mã đơn hàng từ kết quả tìm kiếm
        $order_code = $matches[1];
        
        // Tìm đơn hàng trong cơ sở dữ liệu
        $order = Order::where('order_code', $order_code)->first();

        // Kiểm tra nếu không tìm thấy đơn hàng
        if (!$order) {
            return response()->json(['error' => 'Không tìm thấy đơn hàng với mã: ' . $order_code], 400);
        }

        // Kiểm tra số tiền
        $money = floatval($request->money); // Ép kiểu số tiền từ request thành float
        $totalAmount = floatval($order->total_amount); // Ép kiểu tổng tiền đơn hàng thành float

        if ($money === $totalAmount) {
            
            // Tìm thông tin thanh toán liên quan đến đơn hàng
            $payment = Payment::where('id', $order->payment_id)->first();

            // Kiểm tra trạng thái thanh toán trước khi cập nhật
            if ($payment->payment_status !== ('Đã thanh toán')) {
                $payment->update(['payment_status' => ('Đã thanh toán')]);
            }

            // Lưu lịch sử giao dịch
            HistoryTransaction::create([
                'phone' => $request->phone,
                'money' => $request->money,
                'type' => $request->type,
                'gateway' => $request->gateway,
                'payment_id' => $order->payment_id,
                'txn_id' => $request->txn_id,
                'content' => 'Giao dịch với mã đơn ' . $order->order_code,
                'datetime' => $request->datetime,
                'balance' => $request->balance,
                'number' => $request->number,
            ]);

            return response()->json(['message' => 'Giao dịch thành công!'], 200);
        } else {
            return response()->json(['error' => 'Số tiền không khớp với giá trị đơn hàng'], 400);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Lỗi trong quá trình xử lý: ' . $e->getMessage()], 500);
    }
}



public function checkPayment(Request $request)
{
    $order = Order::where('order_code', $request->order_id)->first();

    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Không tìm thấy đơn hàng']);
    }

    if ($order->payment && $order->payment->payment_status === 'Đã thanh toán') {
        // Trả về URL dẫn đến trang thành công
        return response()->json([
            'success' => true,
            'redirect_url' => route('qr.success')
        ]);
    }

    return response()->json(['success' => false, 'message' => 'Thanh toán chưa hoàn thành']);
}

public function qrSuccessfully()
{
    return view('client.cart.qr_successfully');
}


    

    public function applyVoucher(Request $request)
    {
        try {
            $voucherCode = $request->input('voucher_code');
            $totalAmount = $request->input('total_amount');

            // Kiểm tra xem voucher đã được áp dụng trong session chưa
            if (session()->has('applied_voucher') && session('applied_voucher') === $voucherCode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Voucher này đã được áp dụng.'
                ]);
            }

            // Kiểm tra voucher có tồn tại, còn hạn sử dụng và chưa được sử dụng hết
            $voucher = Voucher::where('code', $voucherCode)
                ->where('usage_limit', '>', 0) // Kiểm tra còn lượt sử dụng
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->first();

            if (!$voucher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Voucher không hợp lệ hoặc đã hết hạn sử dụng.'
                ]);
            }

            // Kiểm tra xem người dùng đã sử dụng voucher này chưa
            $userId = auth()->id();
            $hasUsedVoucher = Order::where('user_id', $userId)
                ->where('voucher_id', $voucher->id)
                ->exists();

            if ($hasUsedVoucher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã sử dụng voucher này rồi.'
                ]);
            }

            // Tính toán giảm giá
            $discount = min($voucher->discount, $totalAmount);

            // Lưu voucher đã áp dụng vào session
            session(['applied_voucher' => $voucherCode]);

            // Trả về kết quả
            return response()->json([
                'success' => true,
                'discount' => $discount,
                'voucher_id' => $voucher->id,
                'message' => 'Áp dụng voucher thành công!'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
    

}
