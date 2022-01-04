<?php

use App\Http\Controllers\api\Admin\{
    ProductCategoryController,
    ProductController,
    TrashCategoryController,
    TrashController,
    UserController,
    OrderController,
    CollectController,
    TransactionController
};

use Illuminate\Support\Facades\Route;

        //Managing Users Routes
        Route::get('/users/total', [UserController::class, 'total']);
        Route::apiResource('/users', UserController::class)->only(['index', 'show']);

        //Managing Orders Routes
        Route::get('/orders/todayOrderCount', [OrderController::class, 'todayOrderCount']);
        Route::get('/orders/total', [OrderController::class, 'total']);
        Route::apiResource('/orders', OrderController::class)->only(['index', 'show']);
        Route::post('/orders/{order}', [OrderController::class, 'process']);

        //Managing Product Routes
        Route::apiResource('/productCategories', ProductCategoryController::class);
        Route::apiResource('/products', ProductController::class);

        //Managing Trash Routes
        Route::apiResource('/trashCategories', TrashCategoryController::class);
        Route::apiResource('/trashes', TrashController::class);

        //Managing Transaction Routes
        Route::get('/transactions/total', [TransactionController::class, 'total']);
        Route::apiResource('/transactions', TransactionController::class)->only(['index', 'show']);

        //Managing Collect Routes
        Route::get('/collects/total', [CollectController::class, 'total']);
        Route::apiResource('/collects', CollectController::class)->only(['store', 'index', 'show']);

