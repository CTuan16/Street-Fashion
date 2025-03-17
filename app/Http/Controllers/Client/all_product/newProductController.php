<?php

namespace App\Http\Controllers\Client\all_product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetail;


class newProductController extends Controller
{
    public function allProductNew()
    {
        $result_product_default = Product::with(['product_meta', 'productcolor', 'productsize'])
            ->whereHas('product_meta', function ($query) {
                $query->where('default', 'default');
            })
            ->whereDoesntHave('product_meta', function ($query) {
                $query->where('product_sale', 'sale');
            })
            ->get();
        return view('client.all_product.new_product', compact('result_product_default'));
    }
    public function allProductSale()
    {
        $result_product_sale =Product::with(['product_meta', 'productcolor', 'productsize'])
        ->whereHas('product_meta', function ($query) {
                $query->where('product_sale', 'sale')
                    ->where('default', '!=', 'default');
            })
            ->get();
        return view('client.all_product.sale_product', compact('result_product_sale'));
    }
     public function allProductBestSeller()
    {
        // Lấy danh sách các sản phẩm bán chạy nhất
        $topSellingProductIds = OrderDetail::select('product_id', DB::raw('SUM(quantity) as quantity'))
            ->groupBy('product_id')
            ->orderBy('quantity', 'desc')
 
            ->pluck('product_id'); // Lấy danh sách product_id

        // Lấy chi tiết sản phẩm bán chạy từ bảng Product
        $topSellingProducts = Product::with(['product_meta', 'productcolor', 'productsize'])
            ->whereIn('id', $topSellingProductIds)  // Lọc sản phẩm theo product_id bán chạy
            ->get();

        return view('client.all_product.best-selling_product', compact('topSellingProducts'));
    }
    public function allProduct()
    {
        $result_product = Product::with(['product_meta', 'productcolor', 'productsize'])
            ->whereDoesntHave('product_meta', function($query) {
                $query->where('product_sale', 'sale')
                    ->orWhere('default', 'default');
            })
            ->get();
        return view('client.all_product.all_product', compact('result_product'));
    }
}
