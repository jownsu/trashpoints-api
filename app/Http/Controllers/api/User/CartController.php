<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\api\ApiController;
use App\Http\Requests\Cart\AddCartRequest;
use App\Http\Requests\Cart\EditCartRequest;
use App\Http\Resources\Cart\CartCollection;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->load('carts.products')->only('carts');
        $data = CartCollection::collection($user['carts']);
        return response()->success($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        if(!$this->isOwnedByUser('delete', $cart )){
            return response()->error('User do not own this item');
        }

        $cart->delete();
        return response()->success('deleted');
    }

    public function addToCart(AddCartRequest $request)
    {
        $item = auth()->user()->carts()->where('product_id', $request->product_id)->first();

        if($item){
            $item->quantity += $request->quantity;
            $item->save();
            return response()->success($item);
        }else{
            $cart = auth()->user()->carts()->create($request->validated());
            return response()->success($cart->products()->first());
        }
    }

    public function checkout()
    {
        $carts = auth()->user()->carts;

        if(count($carts) <= 0){
            return response()->error('Your cart is empty');
        }

        $products = [];
        foreach($carts as $cart){
            array_push($products, [
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity
            ]);
        }

        $order = new Order(['user_id' => auth()->id()]);
        if($order->save()){
            $order->products()->attach($products);
        }

        auth()->user()->carts()->delete();

        return response()->success($order);

    }

}
