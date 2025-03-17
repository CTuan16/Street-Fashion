<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;        
use App\Models\favorite_product;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Get products with different filters
     *
     */
    public function getProducts()
    {
        $user = auth()->user();
        $topSellingProductIds = OrderDetail::select('product_id', DB::raw('SUM(quantity) as quantity'))
        ->groupBy('product_id')
        ->orderBy('quantity', 'desc')
        ->limit(8)
        ->pluck('product_id'); // Lấy danh sách product_id của sản phẩm bán chạy

    // Lấy thông tin chi tiết của các sản phẩm bán chạy nhất
    $topSellingProducts = Product::with(['product_meta'])  // eager load thông tin liên quan
        ->whereIn('id', $topSellingProductIds)  // lọc theo các product_id bán chạy
        ->get();

        // Get all products
        $result_product = Product::with(['product_meta'])
            ->whereDoesntHave('product_meta', function($query) {
                $query->where('product_sale', 'sale')
                    ->orWhere('default', 'default');
            })
            ->limit(12)
            ->get();

        // Get default products (excluding sale products)
        $result_product_default = Product::with(['product_meta'])
            ->whereHas('product_meta', function ($query) {
                $query->where('default', 'default');
            })
            ->whereDoesntHave('product_meta', function ($query) {
                $query->where('product_sale', 'sale');
            })
            ->get();

        // Get sale products only
        $result_product_sale = Product::with(['product_meta'])
            ->whereHas('product_meta', function ($query) {
                $query->where('product_sale', 'sale')
                    ->where('default', '!=', 'default');
            })
            ->get();

        // Remove duplicates by product ID
        $result_product = $result_product->unique('id');
        $result_product_default = $result_product_default->unique('id');
        $result_product_sale = $result_product_sale->unique('id');

        return compact('result_product', 'result_product_default', 'result_product_sale', 'user', 'topSellingProducts');
    }

    /**
     * Display homepage with products
     *
     */
    public function index()
    {
        $products = $this->getProducts();

        return view('client.home', $products);
    }

    /**
     * Toggle favorite status for a product
     */
    public function addFavorite($id)
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        $product = Product::findOrFail($id);
        $favorite = $user->favorite_product()->where('id_product', $product->id)->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorite = false;
        } else {
            $user->favorite_product()->create(['id_product' => $product->id]);
            $isFavorite = true;
        }

        return redirect()->back()->with('success', 'Cập nhật sản phẩm yêu thích thành công');
    }

    public function favoriteProduct()
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        $favorite_products = $user->favorite_product()->with('product')->get();
        
        return view('client.favorite_product', compact('favorite_products'));
    }
}