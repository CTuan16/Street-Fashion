<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\BaseController;
use App\Models\ProductMeta;

class   HomeAdminController extends BaseController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->title = 'StreetFashion';
    }
    public function index()
{
    // Lấy tháng và năm hiện tại
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    // Lấy ngày được chọn từ request, nếu không có thì lấy ngày hiện tại
    $date = request('date') ? Carbon::parse(request('date')) : Carbon::now();
    // Lấy loại thời gian (ngày/tháng/năm), mặc định là 'day'
    $type = request('type', 'day'); // day, month, year

    // Khởi tạo query builder cơ bản cho đơn hàng
    $orderQuery = Order::query();

    // Lọc dữ liệu theo loại thời gian được chọn
    switch ($type) {
        case 'day':
            // Lọc theo ngày cụ thể
            $orderQuery->whereDate('created_at', $date);
            break;
        case 'month':
            // Lọc theo tháng và năm
            $orderQuery->whereYear('created_at', $date->year)
                      ->whereMonth('created_at', $date->month);
            break;
        case 'year':
            // Lọc theo năm
            $orderQuery->whereYear('created_at', $date->year);
            break;
    }

    // Tính tổng thu nhập từ đơn hàng đã giao (status_id = 12)
    $income = (clone $orderQuery)
        ->where('order_status_id', 12)
        ->sum('total_amount');

    // Đếm tổng số đơn hàng trong khoảng thời gian
    $totalOrdersByDate = $orderQuery->count();

    // Thống kê số lượng đơn hàng theo từng trạng thái
    // order_status_id: 9-pending, 11-shipping, 12-delivered, 13-canceled
    $orderStatistics = (clone $orderQuery)
        ->select('order_status_id', DB::raw('count(*) as total'))
        ->whereIn('order_status_id', [9, 11, 12, 13])
        ->groupBy('order_status_id')
        ->get()
        ->keyBy('order_status_id');

    // Tổng hợp số liệu theo từng trạng thái
    $totalOrders = [
        'delivered' => $orderStatistics->get(12)->total ?? 0, // Đã giao
        'shipping' => $orderStatistics->get(11)->total ?? 0,  // Đang giao
        'pending' => $orderStatistics->get(9)->total ?? 0,    // Chờ xử lý
        'canceled' => $orderStatistics->get(13)->total ?? 0,  // Đã hủy
    ];

    // Các thống kê khác không phụ thuộc thời gian
    $totalCategory = category::count(); // Tổng số danh mục
    
    // Lấy top 3 danh mục có nhiều sản phẩm nhất
    $category = category::withCount('product')
        ->orderByDesc('product_count')
        ->take(3)
        ->get();
    
    // Đếm số sản phẩm đang sale
    $totalProductsOnSale = ProductMeta::where('product_sale', 1)->count();

    // Chuẩn bị dữ liệu trả về view
    $data = [
        'totalOrders' => $totalOrders,
        'totalOrdersByDate' => $totalOrdersByDate,
        'income' => $income,
        'selectedDate' => $date->format('Y-m-d'),
        'selectedType' => $type,
        'totalCategory' => $totalCategory,
        'category' => $category,
        'totalProductsOnSale' => $totalProductsOnSale,
        'currentMonth' => $currentMonth,
    ];

    // Xử lý request AJAX - Cập nhật dữ liệu động không reload trang
    if (request()->ajax()) {
        return response()->json([
            'totalOrdersByDate' => number_format($totalOrdersByDate ?? 0, 0, ',', '.'),
            'income' => number_format($income ?? 0, 0, ',', '.') . ' đ',
            'totalOrders' => [
                'delivered' => number_format($totalOrders['delivered'] ?? 0, 0, ',', '.'),
                'shipping' => number_format($totalOrders['shipping'] ?? 0, 0, ',', '.'),
                'pending' => number_format($totalOrders['pending'] ?? 0, 0, ',', '.'),
                'canceled' => number_format($totalOrders['canceled'] ?? 0, 0, ',', '.')
            ]
        ]);
    }

    // Trả về view với dữ liệu đã chuẩn bị
    return view('admin.homev2')->with($data);
}}