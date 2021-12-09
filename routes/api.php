<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\User\CartController;
use App\Http\Controllers\api\User\OrderController;
use App\Http\Controllers\api\User\ProductCategoryController;
use App\Http\Controllers\api\User\ProductController;
use App\Http\Controllers\api\User\TransactionController;
use App\Http\Controllers\api\User\TrashCategoryController;
use App\Http\Controllers\api\User\TrashController;
use App\Http\Controllers\api\User\UserController;
use App\Http\Controllers\api\Admin\ProductCategoryController as AdminProductCategoryController;
use App\Http\Controllers\api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\api\Admin\TrashCategoryController as AdminTrashCategoryController;
use App\Http\Controllers\api\Admin\TrashController as AdminTrashController;
use App\Http\Controllers\api\Admin\UserController as AdminUserController;
use App\Http\Controllers\api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\api\Admin\CollectController as AdminCollectController;
use App\Http\Controllers\api\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\api\Admin\WalletController as AdminWalletController;

use App\Http\Controllers\api\User\WalletController;
use App\Http\Controllers\api\User\CollectController;
use App\Http\Controllers\api\UserWalletController;
use App\Models\TrashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['auth:sanctum']], function(){

    //authentication routes
    Route::post('/changepassword', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // User Routes
    Route::group(['prefix' => '/users'], function(){

        //User Profile Routes
        Route::get('/', [UserController::class, 'index']);
        Route::put('/', [UserController::class, 'update']);
        Route::put('/changepassword', [UserController::class, 'changepassword']);
        Route::put('/uploadavatar', [UserController::class, 'uploadavatar']);

        //Cart Routes
        Route::apiResource('/carts', CartController::class)->only(['index', 'destroy']);
        Route::post('/addToCart', [CartController::class, 'addToCart']);
        Route::post('/checkout', [CartController::class, 'checkout']);

        //Product Routes
        Route::apiResource('/productCategories', ProductCategoryController::class)->only(['index']);
        Route::apiResource('/products', ProductController::class)->only(['index']);

        //Trash Routes
        Route::apiResource('/trashCategories', TrashCategoryController::class)->only(['index']);;
        Route::apiResource('/trashes', TrashController::class)->only(['index']);

        //Order Routes
        Route::apiResource('/orders', OrderController::class)->only(['index', 'show', 'destroy']);

        //Transaction Routes
        Route::apiResource('/transactions', TransactionController::class)->only(['index', 'show']);

        //Collect Routes
        Route::apiResource('/collects', CollectController::class)->only(['index', 'show']);

        //Wallet Routes
        Route::apiResource('/wallet', WalletController::class)->only(['index']);
    });


    // Admin Routes
    Route::group(['middleware' => ['admin'], 'prefix' => '/admin'], function(){

        //Managing Users Routes
        Route::get('/users/total', [AdminUserController::class, 'total']);
        Route::apiResource('/users', AdminUserController::class)->only(['index', 'show']);

        //Managing Orders Routes
        Route::get('/orders/total', [AdminOrderController::class, 'total']);
        Route::apiResource('/orders', AdminOrderController::class)->only(['index', 'show']);
        Route::post('/orders/{order}', [AdminOrderController::class, 'process']);

        //Managing Product Routes
        Route::apiResource('/productCategories', AdminProductCategoryController::class);
        Route::apiResource('/products', AdminProductController::class);

        //Managing Trash Routes
        Route::apiResource('/trashCategories', AdminTrashCategoryController::class);
        Route::apiResource('/trashes', AdminTrashController::class);

        //Managing Transaction Routes
        Route::get('/transactions/total', [AdminTransactionController::class, 'total']);
        Route::apiResource('/transactions', AdminTransactionController::class)->only(['index', 'show']);

        //Managing Collect Routes
        Route::get('/collects/total', [AdminCollectController::class, 'total']);
        Route::apiResource('/collects', AdminCollectController::class)->only(['store', 'index', 'show']);

        //Managing Wallet Routes
        //Route::apiResource('/collect', AdminCollectController::class)->only(['store']);

    });
});

//public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

