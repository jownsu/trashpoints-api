<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Resources\Admin\Order\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::with(['products', 'user.profile']);

        if($request->has('search')){
            if(is_numeric($request->search)){
                $orders->whereHas('user', function($query) use($request){
                    $query->where('id', 'LIKE', '%' . $request->search . '%');
                });
            }else{
                $orders->whereHas('user.profile', function($query) use($request){
                    $query->where('firstname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('middlename', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $request->search . '%');
                });
            }
        }

        if($request->has('per_page') && is_numeric($request->per_page)){
            $data = OrderResource::collection($orders->paginate($request->per_page))
                ->response()
                ->getData(true);
            return response()->successWithPaginate($data);
        }

        return  response()->success( OrderResource::collection($orders->get()));

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

        return response()->success(new OrderResource($order));
    }

}
