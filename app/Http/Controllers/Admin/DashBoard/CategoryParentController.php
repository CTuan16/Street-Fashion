<?php

namespace App\Http\Controllers\Admin\DashBoard;


use App\Models\category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\BaseController;
use App\DataTables\Admin\CategoryParentDataTable;

class CategoryParentController extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
        $this->title = 'Danh sách danh mục cha';
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryParentDataTable $dataTable, Request $request)
    {   
        return $dataTable->render('admin.category.index');
        
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:category_parent|max:255',
    ]);

    // Tạo slug tự động từ name nếu không có giá trị
    $slug = Str::slug($request->name);

    category::create([
        'name' => $request->name,
        'slug' => $slug,
    ]);

    $this->addToLog(request());

    return response(['success' => 'success', 'message' => 'Thêm mới thành công!']);
}

    public function edit($id)
{
    $categoriesparent = category::find($id);
    return view('admin.category.create')->with(['category' => $categoriesparent]);
}

    public function show(Request $request)
    {
        $module = category::findOrFail($request->id);
        return response(['data' => $module]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);
        $module = category::findOrFail($request->id);
        $module->update($request->all());
        $this->addToLog($request);
        return response(['success' => 'success', 'message'=> 'Sửa thành công!']);
    }

    public function destroy(Request $request)
    {
        $data = category::findOrFail($request->id);

        $data->delete();
        $this->addToLog(request());
        return response()->json(['message' => 'Xóa thành công!']);
    }
    
    public function changeStatus(Request $request)
    {
        $module = category::findOrFail($request->id);
        $module->status == 0 ? $module->status =1 : $module->status = 0;
        $module->save();
        $this->addToLog(request());
        return response()->json(['message' => 'Thay đổi thành công!']);
    }
}
