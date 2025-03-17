<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\productController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\sizeSelectionController;
use App\Http\Controllers\ratingController;
use App\Http\Controllers\Client\all_product\newProductController;
use App\Http\Controllers\Client\myacController;
use App\Http\Controllers\Client\ShowOrderController;
use App\Http\Controllers\Comments;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//cart
Route::get('/cart',[CartController::class,'Cart'])->name('cart');
Route::post('/cart/add/{id}',[CartController::class,'AddToCart'])->name('cart.add');
Route::get('/cart/remove/{id}',[CartController::class,'RemoveCart'])->name('cart.remove');
// update cart
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
//addcart
Route::get('/payment',[CartController::class,'Payment'])->name('payment');
Route::get('/order',[CartController::class,'Order']);
Route::get('/information',[CartController::class,'Order_Information']);
Route::get('/search',[productController::class,'Search']);
Route::get('/product/{categoryId}', [productController::class, 'showProducts'])->name('product.showProducts');
Route::get('/product/{categoryId}/{subcategoryId}', [productController::class, 'showProducts'])->name('product.showProduct');

// sp yeu thích
Route::post('/favorites/add/{id}', [HomeController::class, 'addFavorite'])->name('add.favorite');
//binh luan

// ... existing routes ...

//size selection
Route::get('/post', [PostController::class, 'showPost'])->name('size.selection');
// lich su mua hang
Route::get('/purchase-history', [CartController::class, 'PurchaseHistory'])->name('purchase.history');
// thanh toan thanh cong
Route::get('/order-successfully', [CartController::class, 'Order_Successfully'])->name('order.successfully');
// san pham yeu thich
Route::get('/favorite-product', [HomeController::class, 'favoriteProduct'])->name('favorite.product');


//rating
Route::post('/detail/{id}', [ratingController::class, 'store'])->name('rating.store');
//get rating
Route::get('/detail/{id}', [ratingController::class, 'getRating'])->name('get.rating');
//xoa rating
Route::delete('/detail/{id}', [ratingController::class, 'deleteRating'])->name('delete.rating');
//title rating
Route::get('/detail/{id}', [ratingController::class, 'titleRating'])->name('title.rating');

// all product 
Route::get('/all-product-new', [newProductController::class, 'allProductNew'])->name('all.product.new');
Route::get('/all-product-sale', [newProductController::class, 'allProductSale'])->name('all.product.sale');
Route::get('/all-product', [newProductController::class, 'allProduct'])->name('all.product');
Route::get('/all-product-seller', [newProductController::class, 'allProductBestSeller'])->name('all.seller');

// my account
Route::get('/my-account', [myacController::class, 'myAC'])->name('myac');
Route::post('/my-account', [myacController::class, 'updateProfile'])->name('updateProfile');
// lich su mua hang
Route::get('/purchase-history', [ShowOrderController::class, 'showOrder'])->name('purchase.history');
Route::post('/purchase-history/{id}', [ShowOrderController::class, 'cancelOrder'])->name('cancel.order');