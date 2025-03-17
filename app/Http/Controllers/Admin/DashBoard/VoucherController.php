<?php

namespace App\Http\Controllers\Admin\DashBoard;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\DataTables\Admin\VoucherDatatable;
use App\Http\Controllers\Admin\BaseController;

/**
 * Class VoucherController - Controller xử lý các chức năng liên quan đến mã giảm giá
 * @extends BaseController
 */
class VoucherController extends BaseController
{
    /**
     * Khởi tạo controller với tiêu đề mặc định
     */
    public function __construct()
    {
        parent::__construct();
        $this->title = 'Danh sách mã giảm giá';
    }

    /**
     * Hiển thị danh sách mã giảm giá
     * @param VoucherDatatable $dataTable
     * @param Request $request
     * @return mixed
     */
    public function index(VoucherDatatable $dataTable, Request $request)
    {
        return $dataTable->render('admin.vouchers.index');
    }

    /**
     * Tạo mới mã giảm giá
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Validate dữ liệu đầu vào
         $request->validate([
            'code' => 'required|string|unique:vouchers,code|max:255', // Mã voucher phải duy nhất
            'discount' => 'required|numeric|min:0', // Giá trị giảm phải là số dương
            'start_date' => 'required|date', // Ngày bắt đầu bắt buộc
            'end_date' => 'required|date|after_or_equal:start_date', // Ngày kết thúc phải sau ngày bắt đầu
            'usage_limit' => 'nullable|integer|min:0', // Giới hạn sử dụng phải là số nguyên dương
            'usage_count' => 'nullable|integer|min:0', // Số lần đã sử dụng phải là số nguyên dương
        ], [
            // Các thông báo lỗi tùy chỉnh
            'code.required' => 'Vui lòng nhập mã giảm giá',
            'code.unique' => 'Mã giảm giá đã tồn tại',
            'code.max' => 'Mã giảm giá không được vượt quá 255 ký tự',
            'discount.required' => 'Vui lòng nhập số tiền giảm giá',
            'discount.numeric' => 'Số tiền giảm giá phải là số',
            'discount.min' => 'Số tiền giảm giá phải lớn hơn hoặc bằng 0',
            'start_date.required' => 'Vui lòng chọn ngày bắt đầu',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ',
            'end_date.required' => 'Vui lòng chọn ngày kết thúc',
            'end_date.date' => 'Ngày kết thúc không hợp lệ', 
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
        ]);
        
        // Tạo mới voucher
        Voucher::create($request->all());
        // Ghi log
        $this->addToLog(request());
        // Trả về response thành công
        return response(['success' => 'success', 'message'=> 'Thêm mã giảm giá thành công!']);
    }

    /**
     * Hiển thị thông tin chi tiết một mã giảm giá
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = Voucher::findOrFail($request->id);
        return response(['data' => $data]);
    }

    /**
     * Cập nhật thông tin mã giảm giá
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate dữ liệu cập nhật
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:0',
            'usage_count' => 'nullable|integer|min:0',
        ]);

        // Tìm và cập nhật voucher
        $data = Voucher::findOrFail($request->id);
        $data->update($request->all());
        // Ghi log
        $this->addToLog($request);
        // Trả về response thành công
        return response(['success' => 'success', 'message'=> 'Cập nhập thành công!']);
    }

    /**
     * Xóa mã giảm giá
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Tìm và xóa voucher
        $data = Voucher::findOrFail($request->id);
        $data->delete();
        // Ghi log
        $this->addToLog(request());
        // Trả về response thành công
        return response()->json(['message' => 'Xóa thành công!']);
    }
}
