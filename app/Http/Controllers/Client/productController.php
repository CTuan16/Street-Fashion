<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\color;
use App\Models\size;
use App\Models\ProductMeta;
use App\Models\category;
use App\Models\SearchKeyword;
use App\Models\Category_child;
use App\Models\ProductColor;
use App\Models\ProductSize;

class productController extends Controller
{
    public function showProducts($categoryId, $subcategoryId = null)
    {
        // Lấy thông tin danh mục cha
        $category = category::find($categoryId);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        $subcategory = null;

        // Nếu có subcategoryId, lấy sản phẩm theo danh mục con
        if ($subcategoryId) {
            $subcategory = Category_child::find($subcategoryId);
            if (!$subcategory) {
                return redirect()->back()->with('error', 'Subcategory not found');
            }

            $products = Product::with(['product_meta' => function ($query) {
                $query->select('id', 'id_product', 'price', 'price_sale', 'product_sale');
            }, 'productcolor', 'productsize'])
                ->where('id_category_child', $subcategoryId)
                ->paginate(6);

            // Thêm thông tin giá sale cho mỗi sản phẩm
            $products->each(function ($product) {
                $product_meta = $product->product_meta->first();
                if ($product_meta && $product_meta->product_sale == 'sale') {
                    $product->sale_price = $product_meta->price_sale;
                    $product->original_price = $product_meta->price;
                } else {
                    $product->price = $product_meta ? $product_meta->price : 0;
                }

            });

            return view('client.product', compact('products', 'category', 'subcategory'));
        } else {
            // Nếu không có subcategoryId, lấy sản phẩm theo danh mục cha
            $products = Product::with(['product_meta' => function ($query) {
                $query->select('id', 'id_product', 'price', 'price_sale', 'product_sale');
            }])
                ->where('id_category_parent', $categoryId)
                ->paginate(6);

            // Thêm thông tin giá sale cho mỗi sản phẩm
            $products->each(function ($product) {
                $product_meta = $product->product_meta->first();
                if ($product_meta && $product_meta->product_sale == 'sale') {
                    $product->sale_price = $product_meta->price_sale;
                    $product->original_price = $product_meta->price;
                } else {
                    $product->price = $product_meta ? $product_meta->price : 0;
                }
            });

            return view('client.product', compact('products', 'category'));
        }
    }

    // Lấy danh mục
    public function show($categoryId)
    {
        $category = category::with(['category_child' => function ($query) {
            $query->orderBy('name', 'asc');
        }])->findOrFail($categoryId);

        return view('client.product', compact('category'));
    }


    public function detail($id)
    {
        $products = Product::with(['product_meta', 'color', 'size'])
            ->find($id);

        if (!$products) {
            return redirect()->back()->with('error', 'Product not found');
        }

        return view('client.detail', compact('products'));
    }

    // Tìm kiếm sản phẩm
    public function Search(Request $request)
    {
        // Đảm bảo nhận Request
        $query = $request->input('query');

        // Kiểm tra nếu query rỗng thì quay lại trang trước
        if (empty($query)) {
            return redirect()->back()->with('error', 'Vui lòng nhập từ khóa tìm kiếm');
        }

        // Tìm kiếm sản phẩm
        $results = Product::with(['product_meta', 'productcolor', 'productsize', 'Category'])
            ->where('name', 'LIKE', "%{$query}%")->orWhereHas('Category', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%"); // Tên danh mục
            })
            ->get();

        // Tìm hoặc tạo mới từ khóa tìm kiếm
        $keyword = SearchKeyword::firstOrNew(['keyword' => $query]);

        if ($keyword->exists) {
            $keyword->count++;
        } else {
            $keyword->count = 1;
        }

        // Lưu từ khóa vào cơ sở dữ liệu
        $keyword->save();

        // Lấy 3 từ khóa phổ biến nhất
        $popularKeywords = SearchKeyword::orderBy('count', 'desc')->take(5)->get();

        return view('client.cart.search', compact('results', 'query', 'popularKeywords'));
    }
}