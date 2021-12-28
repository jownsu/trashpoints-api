<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\User\{
    CartController,
    OrderController,
    ProductCategoryController,
    ProductController,
    TransactionController,
    TrashCategoryController,
    TrashController,
    UserController,
    WalletController,
    CollectController
};


//public routes
Route::post('/token/register', [AuthController::class, 'register']);
Route::post('/token/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){

    //authentication routes
    Route::post('/token/changepassword', [AuthController::class, 'changePassword']);
    Route::post('/token/logout', [AuthController::class, 'logout']);

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
});


//TEST IF MY REPOSITORY IS CONNECTED TO HOSTINGER

// YEY CONNECTED

