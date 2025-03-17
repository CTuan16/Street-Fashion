<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ManagerUser;
use App\Http\Controllers\Client\productController;
use App\Http\Controllers\Client\formController;
use App\Http\Controllers\Client\detallController;
use App\Http\Controllers\Admin\admin\productAd;
use App\Http\Controllers\Admin\admin\userAD;
use App\Http\Controllers\Client\myacController;






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

// Route::get('/login', [ManagerUser::class, 'Login'])->name('login');
// Route::get('/register', [ManagerUser::class, 'Register']);
Route::get('/confirm', [ManagerUser::class, 'Confirm']);
Route::get('/product/{id}',[productController::class,'showProducts'])->name('product.showProducts');
// Route::post('/login', [formController::class, 'Checkdn'])->name('login');
// Route::post('/register', [formController::class, 'Checkdk'])->name('register');
Route::post('/forgot', [formController::class, 'Checkfg'])->name('forgot');
Route::post('/confirm', [formController::class, 'Checkcf'])->name('confirm');
Route::get('/detail/{id}', [productController::class, 'detail'])->name('detail');
Route::get('/logout', [formController::class, 'Logout']);
Route::get('/qlsanpham', [productAd::class, 'showProductadmin']);
Route::get('/qlsanpham', [productAd::class, 'showProductadmin']);
Route::delete('/qlsanpham/delete/{id}', [productAd::class, 'destroyProduct'])->name('qlsanpham.destroy');
Route::get('/qltaikhoan', [userAD::class, 'showUser']);
Route::delete('/qltaikhoan/delete/{id}', [UserAD::class, 'destroy'])->name('qltaikhoan.destroy');
Route::get('/qltaikhoan/edit/{id}', [userAD::class, 'edit'])->name('accounts.edit');
Route::put('/qltaikhoan/update/{id}', [userAD::class, 'update'])->name('accounts.update');
Route::get('/qlsanpham/create', [productAd::class, 'create'])->name('products.create');
Route::post('/qlsanpham', [productAd::class, 'store'])->name('products.store');
Route::get('/myaccount', [myacController::class, 'myAC'])->name('profile');

