<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Client\ManagerUser;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\VerifyOtpController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\formController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\Client\OrderController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DashBoard\RoleController;
use App\Http\Controllers\Admin\DashBoard\OrdersController;
use App\Http\Controllers\Admin\DashBoard\ModulesController;
use App\Http\Controllers\Admin\DashBoard\VoucherController;
use App\Http\Controllers\Admin\DashBoard\ProductsController;
use App\Http\Controllers\Admin\DashBoard\GroupmoduleController;
use App\Http\Controllers\Admin\DashBoard\CategoryChildController;
use App\Http\Controllers\Admin\DashBoard\LogactivitiesController;
use App\Http\Controllers\Admin\DashBoard\GeneralSettingsController;
use App\Http\Controllers\Admin\DashBoard\UserController as UserAdminController;



Route::group(['middleware' => ['auth'], 'prefix'=>'admin'], function () {
    Auth::routes();
    Route::get('/', [HomeAdminController::class, 'index'])->name('admin');

    
        Route::prefix('setting')->group(function () {
            Route::get('/', [GeneralSettingsController::class, 'index'])->name('general_settings.index');
            Route::post('/edit', [GeneralSettingsController::class, 'postEdit'])->name('general_settings.edit');
            Route::post('/saveUriSetting',  [GeneralSettingsController::class, 'saveUriSetting'])->name('general_settings.saveUriSetting');
            Route::post('/sendMailManually',  [GeneralSettingsController::class, 'sendMailManually'])->name('general_settings.sendMailManually');
        });

       
        Route::prefix('user')->group(function () {
            Route::get('/', [UserAdminController::class, 'index'])->name('user.index');
            Route::get('/edit/{id}', [UserAdminController::class, 'edit'])->name('user.edit');
            Route::get('/create', [UserAdminController::class, 'create'])->name('user.create');
            Route::put('/update', [UserAdminController::class, 'update'])->name('user.update');
            Route::post('/store', [UserAdminController::class, 'store'])->name('user.store');
            Route::post('/login', [UserAdminController::class, 'login'])->name('user.login');
            Route::put('/update/{id}', [UserAdminController::class, 'update'])->name('user.update');
            Route::post('/destroy', [UserAdminController::class, 'destroy'])->name('user.destroy');
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductsController::class, 'index'])->name('admin.products.index');
            Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');
            Route::get('/create', [ProductsController::class, 'create'])->name('products.create');
            Route::post('/store', [ProductsController::class, 'store'])->name('products.store');
            Route::post('/login', [ProductsController::class, 'login'])->name('products.login');
            Route::put('/update/{id}', [ProductsController::class, 'update'])->name('products.update');
            Route::post('/destroy', [ProductsController::class, 'destroy'])->name('products.destroy');
        });

        Route::prefix('category-child')->group(function () {
            Route::get('/', [CategoryChildController::class, 'index'])->name('category-child.index');
            Route::get('/edit/{id}', [CategoryChildController::class, 'edit'])->name('category-child.edit');
            Route::get('/create', [CategoryChildController::class, 'create'])->name('category-child.create');
            Route::post('/show', [CategoryChildController::class, 'show'])->name('category-child.show');
            Route::post('/store', [CategoryChildController::class, 'store'])->name('category-child.store');
            Route::post('/login', [CategoryChildController::class, 'login'])->name('categories.login');
            Route::put('/update/{id}', [CategoryChildController::class, 'update'])->name('category-child.update');
            Route::post('/destroy', [CategoryChildController::class, 'destroy'])->name('category-child.destroy');
        });
        
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrdersController::class, 'index'])->name('orders.index');
            Route::get('/import-view', [OrdersController::class, 'importView'])->name('orders.import.view');
            Route::post('/import', [OrdersController::class, 'import'])->name('orders.import');
            Route::get('/edit/{id}', [OrdersController::class, 'edit'])->name('orders.edit');
            Route::post('/show', [OrdersController::class, 'show'])->name('orders.show');
            Route::get('/create', [OrdersController::class, 'create'])->name('orders.create');
            Route::post('/store', [OrdersController::class, 'store'])->name('orders.store');
            Route::put('/update/{id}', [OrdersController::class, 'update'])->name('orders.update');
            Route::post('/destroy', [OrdersController::class, 'destroy'])->name('orders.destroy');
            Route::post('/orders/update-status', [OrdersController::class, 'updateStatus'])->name('orders.updateStatus');
            Route::post('/update-payment-status', [OrdersController::class, 'updatePaymentStatus'])->name('update.payment.status');
            Route::get('/view/{id}', [OrdersController::class, 'view'])->name('orders.view');
        });

        Route::prefix('vouchers')->group(function () {
            Route::get('/', [VoucherController::class, 'index'])->name('vouchers.index');
            Route::get('/edit/{id}', [VoucherController::class, 'edit'])->name('vouchers.edit');
            Route::post('/show', [VoucherController::class, 'show'])->name('vouchers.show');
            Route::get('/create', [VoucherController::class, 'create'])->name('vouchers.create');
            Route::post('/store', [VoucherController::class, 'store'])->name('vouchers.store');
            Route::put('/update/{id}', [VoucherController::class, 'update'])->name('vouchers.update');
            Route::post('/destroy', [VoucherController::class, 'destroy'])->name('vouchers.destroy');
        });
        
        Route::prefix('modules')->group(function () {
            Route::get('/',  [ModulesController::class, 'index'])->name('modules.index');
            Route::get('/edit/{id}',  [ModulesController::class, 'edit'])->name('modules.edit');
            Route::post('/show',  [ModulesController::class, 'show'])->name('modules.show');
            Route::get('/create',  [ModulesController::class, 'create'])->name('modules.create');
            Route::post('/store',  [ModulesController::class, 'store'])->name('modules.store');
            Route::post('/update/{id}',  [ModulesController::class, 'update'])->name('modules.update');
            Route::post('/destroy',  [ModulesController::class, 'destroy'])->name('modules.destroy');
        });

        Route::prefix('groupmodule')->group(function () {
            Route::get('/', [GroupmoduleController::class, 'index'])->name('groupmodule.index');
            Route::get('/edit/{id}', [GroupmoduleController::class, 'edit'])->name('groupmodule.edit');
            Route::get('/create', [GroupmoduleController::class, 'create'])->name('groupmodule.create');
            Route::post('/store', [GroupmoduleController::class, 'store'])->name('groupmodule.store');
            Route::put('/update/{id}', [GroupmoduleController::class, 'update'])->name('groupmodule.update');
            Route::post('/destroy', [GroupmoduleController::class, 'destroy'])->name('groupmodule.destroy');
        });

        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('role.index');
            Route::get('/edit/{id?}', [RoleController::class, 'edit'])->name('role.edit');
            Route::post('/update/{id?}', [RoleController::class, 'update'])->name('role.update');
            Route::get('/create', [RoleController::class, 'create'])->name('role.create');
            Route::post('/store', [RoleController::class, 'store'])->name('role.store');
            Route::post('/destroy', [RoleController::class, 'destroy'])->name('role.destroy');
        });

        Route::prefix('logactivities')->group(function () {
            Route::get('/', [LogactivitiesController::class, 'index'])->name('logactivities.index');
            Route::post('/clearLog', [LogactivitiesController::class, 'clearLog'])->name('logactivities.clearLog');
            Route::delete('/destroy/{id}', [LogactivitiesController::class, 'destroy'])->name('logactivities.destroy');
        });
    
}
);

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/forgot', [ManagerUser::class, 'Forgot'])->name('forgotView');
Route::post('/forgotpassword', [UserController::class, 'sendOtp'])->name('forgotpassword');
Route::get('/verify_otp', [UserController::class, 'showVerifyOtpForm'])->name('verifyOtpForm');
Route::post('/verify_otp', [VerifyOtpController::class, 'verifyOtpForm'])->name('verifyOtpForm'); 
Route::get('/reset_password', [UserController::class, 'showResetPasswordForm'])->name('resetPasswordForm');
Route::post('/reset_password', [UserController::class, 'resetPassword'])->name('resetPassword');

Route::get('login/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('google-login');
Route::get('login/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);
Route::get('/login', [ManagerUser::class, 'Login'])->name('login');
Route::get('/register', [ManagerUser::class, 'Register']);
Route::post('/login', [formController::class, 'Checkdn'])->name('login');
Route::post('/register', [formController::class, 'Checkdk'])->name('register');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

Route::post('/checkPayment', [OrderController::class, 'checkPayment'])->name('order.checkpayment');
Route::get('/qr-successfully', [OrderController::class, 'qrSuccessfully'])->name('qr.success');
Route::post('/thueapi-hooks', [OrderController::class, 'thueapi_hooks']);
Route::post('/apply-voucher', [OrderController::class, 'applyVoucher'])->name('apply.voucher');
Route::post('/cart/add', [CartController::class, 'addToCarts'])->middleware('auth');
Route::get('/cart', [CartController::class, 'getCarts'])->middleware('auth');
Route::get('/admin/homev2', [HomeAdminController::class, 'index'])->name('admin.homev2');
// Route::get('admin/homev2', [DashboardController::class, 'index'])->name('admin.home');
