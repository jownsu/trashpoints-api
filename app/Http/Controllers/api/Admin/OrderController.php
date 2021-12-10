<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Resources\Admin\Order\OrderCollection;
use App\Http\Resources\Admin\Order\OrderResource;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::with(['user.profile']);

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

            $total = $orders->count();
            $paginationData = $this->paginate($total);

            $orders->offset(($paginationData['current_page'] - 1) * $paginationData['per_page'])
                   ->limit($paginationData['per_page']);

            $data = OrderCollection::collection($orders->get());
            return response()->successWithPaginate($data, $paginationData);
        }

        return  response()->success( OrderCollection::collection($orders->get()));

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

    public function process(Order $order)
    {
        $orders = $order->products;

        $products = [];
        foreach ($orders as $prod){
            array_push($products, [
                'product_id' => $prod->id,
                'quantity' => $prod->pivot->quantity,
                'price' => $prod->pivot->price
            ]);
        }

        $transaction = new Transaction(['user_id' => $order->user_id]);
        if($transaction->save()){
            $transaction->products()->attach($products);
            $order->delete();
        }

        return response()->success($transaction);
    }

    public function total()
    {
        return response()->success($this->pivotTotal('order_product', 'total_pending_points', 'price'));
    }

}
