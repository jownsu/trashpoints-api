<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\Order\OrderCollection;
use App\Http\Resources\User\Order\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->with('products')->get();

        return response()->success(OrderCollection::collection($orders));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if(!$this->isOwnedByUser('view', $order)){
            return response()->error('This Order is not owned by user');
        }
        $order->load('products');

        return response()->success(new OrderResource($order));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if(!$this->isOwnedByUser('view', $order)){
            return response()->error('This Order is not owned by user');
        }

        $order->delete();

        return response()->success('Order deleted');
    }
}
