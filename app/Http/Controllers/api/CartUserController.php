<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddCartRequest;
use App\Http\Requests\Cart\EditCartRequest;
use App\Http\Resources\Cart\CartCollection;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartUserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->load('carts.products')->only('carts');


        $data = CartCollection::collection($user['carts']);

        return response()->success($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCartRequest $request)
    {
        $input = $request->validated();

        $cart = auth()->user()->carts()->create([
            'product_id' => $input['product_id'],
            'quantity'  => $input['quantity']
        ]);

        return response()->success($cart->products()->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCartRequest $request, Cart $cart)
    {
        $input = $request->validated();

        if(!$this->isOwnedByUser('update', $cart )){
            return response()->error('User do not own this item');
        }

//        $cart->product_id = $input->product_id;
        $cart->quantity = $input['quantity'];
        $cart->save();

//        $data = new CartResource($cart);
//        return response()->success($data);

        return response()->success('Cart updated');

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

    public function show($id)
    {
        $product = Cart::where('product_id', $id)->first();

        return response()->success($product);
    }
}
