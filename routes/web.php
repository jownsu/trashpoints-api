<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\api\ProductCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\api\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', [TestController::class, 'index']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/admin', [AdminController::class, 'index'])->name('dashboard');

Route::resource('/admin/users', UserController::class)->only(['index']);
Route::resource('admin/trashes', TrashController::class)->only(['index', 'store', 'destroy']);
Route::resource('admin/products', ProductController::class)->only(['index', 'store', 'destroy']);

Route::get('admin/categories', [CategoryController::class, 'index'])->name('categories');

Route::post('admin/categories/product', [CategoryController::class, 'addProductCategory'])->name('addProductCategory');
Route::post('admin/categories/trash', [CategoryController::class, 'addTrashCategory'])->name('addTrashCategory');

Route::delete('admin/categories/product/{id}', [CategoryController::class, 'deleteProductCategory'])->name('deleteProductCategory');
Route::delete('admin/categories/trash/{id}', [CategoryController::class, 'deleteTrashCategory'])->name('deleteTrashCategory');

