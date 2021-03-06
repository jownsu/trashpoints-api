<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\api\ApiController;
use App\Http\Requests\Cart\AddCartRequest;
use App\Http\Requests\Cart\EditCartRequest;
use App\Http\Resources\User\Cart\CartResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $data = CartResource::collection($user['carts']);
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
            if($request->has('new_quantity') && $request->new_quantity > 0){
                $item->quantity = $request->new_quantity;
            }else{
                $item->quantity += $request->quantity;
            }
            $item->save();
            return response()->success($item);
        }else{
            $cart = auth()->user()->carts()->create($request->validated());
            return response()->success($cart->products()->first());
        }
    }

    public function checkout()
    {
        $user = auth()->user()->load('carts.products');
        $wallet = $user->getWallet();

        if(count($user->carts) <= 0) return response()->error('Your cart is empty');

        $products = [];
        $total_price = 0;
        foreach($user->carts as $cart){

            array_push($products, [
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'price' => $cart->products[0]->price
            ]);

            $total_price += $cart->quantity * $cart->products[0]->price;
        }

        if($total_price > $wallet['balance']) return response()->error('Insufficient Balance');

        $order = new Order(['user_id' => auth()->id()]);
        if($order->save()){
            $order->products()->attach($products);
        }

        auth()->user()->carts()->delete();

        return response()->success($order);

    }

}
