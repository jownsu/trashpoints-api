<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Resources\Admin\Order\OrderResource;
use App\Models\Order;
use App\Models\Transaction;
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

//        if($request->has('per_page') && is_numeric($request->per_page)){
//            $data = OrderResource::collection($orders->paginate($request->per_page))
//                ->response()
//                ->getData(true);
//            return response()->successWithPaginate($data);
//        }

        if($request->has('per_page') && is_numeric($request->per_page)){
            $page = ($request->has('page') && is_numeric($request->page))
                ? $request->page
                : 1;

            $per_page = $request->per_page;

            $total = $orders->count();
            $total_pages = ceil($total / $per_page);

            $pages = [];

            for ($i=1; $i <= $total_pages; $i++){
                array_push($pages, $i);
            }

            $orders->offset(($page - 1) * $per_page)->limit($per_page);

            return response([
                'data'         => OrderResource::collection($orders->get()),
                'total_pages'  => $pages,
                'current_page' => (int) $page,
                'has_next'     => ($page < $total_pages) ? true : false,
                'has_prev'     => ($page > 1 ) ? true : false
            ]);
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

    public function process(Order $order)
    {
        $orders = $order->products;

        $products = [];
        foreach ($orders as $prod){
            array_push($products, [
                'product_id' => $prod->id,
                'quantity' => $prod->pivot->quantity
            ]);
        }

        $transaction = new Transaction(['user_id' => $order->user_id]);
        if($transaction->save()){
            $transaction->products()->attach($products);
            $order->delete();
        }

        return response()->success($transaction);
    }

}
