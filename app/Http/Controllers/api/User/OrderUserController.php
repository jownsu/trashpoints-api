<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserOrder\StoreOrderRequest;
use App\Http\Resources\Order\UserOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderUserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['products', 'user.profile'])->get();

        $data = UserOrderResource::collection($orders);

        return response()->success($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->load(['products', 'user.profile']);

        return response()->success(new UserOrderResource($order));
    }

}
