<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CartUserController;
use App\Http\Controllers\api\MeController;
use App\Http\Controllers\api\ProductCategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\TrashCategoryController;
use App\Http\Controllers\api\TrashController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\UserWalletController;
use App\Http\Controllers\api\WalletController;
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

    //current user routes
    Route::apiResource('/users', UserController::class)->only(['index', 'show', 'update']);
    Route::apiResource('/me', MeController::class)->only(['index', 'update']);
    Route::get('/me/getBalance', [MeController::class, 'getBalance']);
    Route::apiResource('myWallet', WalletController::class)->only(['index']);

    Route::put('/uploadavatar', [MeController::class, 'uploadavatar']);

    //products routes
    Route::apiResource('/productCategories', ProductCategoryController::class);
    Route::apiResource('/products', ProductController::class);

    //trash accepted routes
    Route::apiResource('/trashCategories', TrashCategoryController::class);
    Route::apiResource('/trashes', TrashController::class);

    //cart routes
    Route::apiResource('/carts', CartUserController::class);

    //test
    Route::post('/addPoints', [UserWalletController::class, 'addPoints']);
} );

//public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

