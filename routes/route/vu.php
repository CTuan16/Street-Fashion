<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\DashBoard\PostController;
use App\Http\Controllers\Admin\DashBoard\CommentController;
use App\Http\Controllers\Admin\DashBoard\CategoryParentController;

Route::group(['middleware' => ['auth'], 'prefix'=>'admin'], function () {
    Auth::routes();
    Route::get('/', [HomeAdminController::class, 'index'])->name('admin');


Route::prefix('post')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('post.index');
            Route::get('/create', [PostController::class, 'create'])->name('post.create');
            Route::post('/store', [PostController::class, 'store'])->name('post.store');
            Route::get('/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
            Route::put('/update/{id}', [PostController::class, 'update'])->name('post.update');
            Route::post('/destroy', [PostController::class, 'destroy'])->name('post.destroy');
        });
        
Route::prefix('category-parent')->group(function () {
            Route::get('/', [CategoryParentController::class, 'index'])->name('category-parent.index');
            Route::get('/edit/{id}', [CategoryParentController::class, 'edit'])->name('category-parent.edit');
            Route::post('/show', [CategoryParentController::class, 'show'])->name('category-parent.show');
            Route::get('/create', [CategoryParentController::class, 'create'])->name('category-parent.create');
            Route::post('/store', [CategoryParentController::class, 'store'])->name('category-parent.store');
            Route::put('/update/{id}', [CategoryParentController::class, 'update'])->name('category-parent.update');
            Route::post('/destroy', [CategoryParentController::class, 'destroy'])->name('category-parent.destroy');
        });
        
        
Route::prefix('comment')->group(function () {
            Route::get('/', [CommentController::class, 'index'])->name('comment.index');
            Route::post('/show', [CommentController::class, 'show'])->name('comment.show');
            Route::post('/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');
        });


});


