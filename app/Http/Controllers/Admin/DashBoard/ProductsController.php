<?php

namespace App\Http\Controllers\Admin\DashBoard;

use App\Models\Product;

use Illuminate\Http\Request;

use App\Models\Category_child;
use Illuminate\Support\Facades\Storage;
use App\DataTables\Admin\ProductsDataTable;
use App\Http\Controllers\Admin\BaseController;
use App\Models\size;
use App\Models\color;
use App\Models\ProductColor;
use App\Models\ProductMeta;
use App\Models\ProductSize;

class ProductsController extends BaseController
{

    public $model;
    public function __construct()
    {
        parent::__construct();
        $this->title = 'Danh sach sản phẩm';
        $this->model = new Product();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductsDataTable $dataTable, Request $request)
    {
        return $dataTable->render('admin.products.index');
    }
    public function getAll($model)
    {
        return $model::all();  // Lấy tất cả các bản ghi từ bảng liên quan
    }
    public function create(Request $request)
{
    // Lấy danh sách danh mục và thương hiệu
    $list_categories = $this->getAll(new Category_child);
    $list_sizes = $this->getAll(new size);  
    $list_colors = $this->getAll(new color);
    

    // Chuẩn bị dữ liệu để gửi vào view
    $data = [
        'list_categories' => $list_categories ,
        'list_sizes' => $list_sizes ,
        'list_colors' => $list_colors
       
    ];

    // Trả về view với dữ liệu đã chuẩn bị
    return view('admin.products.create', ['data' => $data]);
}


    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255', // Tên sản phẩm không được để trống và không quá 255 ký tự
            'path_1.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Hình ảnh phải đúng định dạng và dung lượng không quá 2MB
            'id_category_child' => 'required', // Danh mục sản phẩm không được để trống
            'quantity' => 'required|integer|min:1', // Số lượng sản phẩm phải là số nguyên và lớn hơn 0
            'price' => 'required|numeric|min:0', // Giá bán sản phẩm phải là số và lớn hơn hoặc bằng 0
            'price_sale' => 'nullable|numeric|min:0', // Giá khuyến mãi sản phẩm phải là số và lớn hơn hoặc bằng 0 (có thể để trống)
            'sizes' => 'required|array|min:1', // Kích thước sản phẩm phải chọn ít nhất 1 
            'colors' => 'required|array|min:1', // Màu sắc sản phẩm phải chọn ít nhất 1
            'description' => 'string|max:1000', // Thêm validation cho description
        ], [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự',
            'path_1.*.image' => 'File phải là hình ảnh',
            'path_1.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp',
            'path_1.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
            'id_category_child.required' => 'Vui lòng chọn danh mục sản phẩm',
            'quantity.required' => 'Vui lòng nhập số lượng sản phẩm',
            'quantity.integer' => 'Số lượng phải là số nguyên',
            'quantity.min' => 'Số lượng phải lớn hơn 0',
            'price.required' => 'Vui lòng nhập giá bán sản phẩm',
            'price.numeric' => 'Giá bán phải là số',
            'price.min' => 'Giá bán phải lớn hơn hoặc bằng 0',
            'price_sale.numeric' => 'Giá khuyến mãi phải là số',
            'price_sale.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0',
            'sizes.required' => 'Vui lòng chọn ít nhất một kích thước',
            'sizes.min' => 'Vui lòng chọn ít nhất một kích thước',
            'colors.required' => 'Vui lòng chọn ít nhất một màu sắc',
            'colors.min' => 'Vui lòng chọn ít nhất một màu sắc',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự'
        ]);

        // Lấy id_category_parent từ bảng Category_child
        $categoryChild = Category_child::find($request->id_category_child);
        $id_category_parent = $categoryChild->id_parent;

        

        // Tạo sản phẩm và gán id_category_parent
        $productData = $request->all();
        
        $productData['id_category_parent'] = $id_category_parent;
        $product = Product::create($productData);

        if ($request->hasFile('path_1')) {
            $images = [];
            if ($request->hasFile('path_1')) {
                foreach ($request->file('path_1') as $image) {
                    // Tạo tên tệp duy nhất
                    $filename = hash('sha256', time() . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        
                    // Lưu hình ảnh vào thư mục 'upload/products'
                    $path = $image->storeAs('upload/products', $filename, 'public');
                    $dbPath = '/storage/' . $path; // Đường dẫn lưu trong cơ sở dữ liệu
        
                    // Lưu đường dẫn vào mảng hình ảnh
                    $images[] = $dbPath;
                }
        
                // Cập nhật hình ảnh vào trường 'primary_image' hoặc 'second_image' trong bảng 'Product'
                if (count($images) > 0) {
                    $product->primary_image = $images[0]; // Lưu hình ảnh đầu tiên làm hình ảnh chính
        
                    // Nếu có hình ảnh thứ hai, lưu vào trường second_image
                    if (count($images) > 1) {
                        $product->second_image = $images[1];
                        
                    }}

                    

                    
        // Lưu cập nhật sản phẩm
        $product->save();
        $sizes = $request->input('sizes');
        foreach ((array)$sizes as $sizeName) {
            ProductSize::create([
                'id_product' => $product->id,
                'size_id' => $sizeName, // Mỗi phần tử là một kích thước
            ]);
        }
        $colors = $request->input('colors'); // Giả sử đây là mảng
        foreach ($colors as $colorName) {
            ProductColor::create([
                'id_product' => $product->id,
                'color_id' => $colorName, // Mỗi phần tử là một kích thước
            ]);
        }
        
        
        $productmeta=ProductMeta::create([
            'id_product' => $product->id,
            'price'=>$request->input('price'),
            'quantity'=>$request->input('quantity'),
            'price_sale'=> $request->input('price_sale'),
            'product_sale' => $request->input('product_sale', 2), // Mặc định là 2 nếu không chọn
        ]);
    }
}

        return redirect()->route('admin.products.index')->with(['status'=>'success', 'html' => 'Thành công']);
    }

    public function edit($id)
    {
        $list_categories = $this->getAll(new Category_child);
        $list_sizes = $this->getAll(new size);  
        $list_colors = $this->getAll(new color);
        
        // Load product với đầy đủ relationships
        $product = Product::with(['product_meta', 'productsize', 'productcolor'])->findOrFail($id);

        // Kiểm tra xem có product_meta không, nếu không thì tạo mới
        if (!$product->product_meta->first()) {
            $product_meta = new ProductMeta([
                'id_product' => $product->id,
                'product_sale' => 2 // Mặc định là không sale
            ]);
            $product_meta->save();
            $product->load('product_meta'); // Load lại relationship
        }

        $data = [
            'list_categories' => $list_categories,
            'list_sizes' => $list_sizes,
            'list_colors' => $list_colors
        ];
        
        return view('admin.products.edit', compact('product', 'data'));
    }

    

    public function update(Request $request, $id)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:255', // Tên sản phẩm không được để trống và không quá 255 ký tự
        'path_1.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Hình ảnh phải đúng định dạng và dung lượng không quá 2MB
        'id_category_child' => 'required', // Danh mục sản phẩm không được để trống
        'quantity' => 'required|integer|min:1', // Số lượng sản phẩm phải là số nguyên và lớn hơn 0
        'price' => 'required|numeric|min:0', // Giá bán sản phẩm phải là số và lớn hơn hoặc bằng 0
        'price_sale' => 'nullable|numeric|min:0', // Giá khuyến mãi sản phẩm phải là số và lớn hơn hoặc bằng 0 (có thể để trống)
        'sizes' => 'required|array|min:1', // Kích thước sản phẩm phải chọn ít nhất 1 
        'colors' => 'required|array|min:1', // Màu sắc sản phẩm phải chọn ít nhất 1
        'description' => 'string|max:1000', // Thêm validation cho description
    ], [
        'name.required' => 'Vui lòng nhập tên sản phẩm',
        'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự',
        'path_1.*.image' => 'File phải là hình ảnh',
        'path_1.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp',
        'path_1.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
        'id_category_child.required' => 'Vui lòng chọn danh mục sản phẩm',
        'quantity.required' => 'Vui lòng nhập số lượng sản phẩm',
        'quantity.integer' => 'Số lượng phải là số nguyên',
        'quantity.min' => 'Số lượng phải lớn hơn 0',
        'price.required' => 'Vui lòng nhập giá bán sản phẩm',
        'price.numeric' => 'Giá bán phải là số',
        'price.min' => 'Giá bán phải lớn hơn hoặc bằng 0',
        'price_sale.numeric' => 'Giá khuyến mãi phải là số',
        'price_sale.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0',
        'sizes.required' => 'Vui lòng chọn ít nhất một kích thước',
        'sizes.min' => 'Vui lòng chọn ít nhất một kích thước',
        'colors.required' => 'Vui lòng chọn ít nhất một màu sắc',
        'colors.min' => 'Vui lòng chọn ít nhất một màu sắc',
        'description.max' => 'Mô tả không được vượt quá 1000 ký tự'
    ]);

    // Tìm sản phẩm cần cập nhật
    $product = Product::findOrFail($id);

    // Lấy `id_category_parent` từ bảng `Category_child` dựa trên `id_category_child` mới
    $categoryChild = Category_child::find($request->id_category_child);
    $id_category_parent = $categoryChild ? $categoryChild->id_parent : null;

    // Cập nhật thông tin sản phẩm
    $product->name = $request->input('name');
    $product->id_category_child = $request->input('id_category_child');
    $product->id_category_parent = $id_category_parent;
    $product->status = $request->has('status') ? 1 : 0;
    $product->description = $request->input('description');

    // Kiểm tra nếu product_meta tồn tại
    $product_meta = $product->product_meta->first();
    if (!$product_meta) {
        // Nếu không tìm thấy product_meta, tạo mới
        $product_meta = new ProductMeta();
        $product_meta->id_product = $product->id;
    }

    // **Xử lý giá trị product_sale**
    // Nếu không có giá trị được gửi từ request, đặt giá trị mặc định là "2" (Không sale)
    $product_meta->product_sale = $request->input('product_sale', 2);
    $product_meta->price = $request->input('price');
    $product_meta->price_sale = $request->input('price_sale');
    $product_meta->quantity = $request->input('quantity');
    $product_meta->save();

    // Lưu thông tin sản phẩm
    $product->save();

    // **Xử lý kích thước (Sizes)**
    $sizesFromRequest = (array) $request->input('sizes', []);
    $currentSizes = $product->productsize->pluck('size_id')->toArray();
    $sizesToDelete = array_diff($currentSizes, $sizesFromRequest);
    $sizesToAdd = array_diff($sizesFromRequest, $currentSizes);

    if (!empty($sizesToDelete)) {
        ProductSize::where('id_product', $product->id)
            ->whereIn('size_id', $sizesToDelete)
            ->delete();
    }
    foreach ($sizesToAdd as $sizeId) {
        ProductSize::create([
            'id_product' => $product->id,
            'size_id' => $sizeId,
        ]);
    }

    // **Xử lý màu sắc (Colors)**
    $colorsFromRequest = (array) $request->input('colors', []);
    $currentColors = $product->productcolor->pluck('color_id')->toArray();
    $colorsToDelete = array_diff($currentColors, $colorsFromRequest);
    $colorsToAdd = array_diff($colorsFromRequest, $currentColors);

    if (!empty($colorsToDelete)) {
        ProductColor::where('id_product', $product->id)
            ->whereIn('color_id', $colorsToDelete)
            ->delete();
    }
    foreach ($colorsToAdd as $colorId) {
        ProductColor::create([
            'id_product' => $product->id,
            'color_id' => $colorId,
        ]);
    }
    // **Xóa hình ảnh**
    if ($request->input('deleted_images')) {
        $deletedImageIds = explode(',', $request->input('deleted_images'));
        foreach ($deletedImageIds as $deletedImageId) {
            $imageToDelete = Product::find($deletedImageId);
            if ($imageToDelete) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $imageToDelete->image_path));
                $imageToDelete->primary_image = '';
                $imageToDelete->second_image = '';
                $imageToDelete->save();
            }
        }
    }
    // **Xử lý hình ảnh**
    $images = [];
    if ($request->hasFile('path_1')) {
        foreach ($request->file('path_1') as $image) {
            $filename = hash('sha256', time() . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('upload/products', $filename, 'public');
            $dbPath = '/storage/' . $path;
            $images[] = $dbPath;
        }

        if (count($images) > 0) {
            $product->primary_image = $images[0];
            if (count($images) > 1) {
                $product->second_image = $images[1];
            }
            $product->save();
        }
    }
    // Trả về thông báo thành công
    return redirect()->route('admin.products.index')
    ->with(['status'=>'success', 'html' => 'Cập nhật thành công']);
}

    


    public function login(Request $request)
    {
        auth()->loginUsingId($request->id);
        return redirect()->intended('/');
    }

   public function destroy(Request $request)
   {
       $this->model->destroy($request->id);
       $this->addToLog(request());
       return response()->json(['message' => 'Xóa thành công!']);
   }
}
