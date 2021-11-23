<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\api\ApiController;
use App\Http\Resources\User\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('category')){
            $products = Product::where('product_category_id', $request->category);

            if($request->has('search')){
                $products->where('name', 'LIKE', '%'. $request->search .'%');
            }

            return response()->success(new ProductResource($products->get()));
        }

        return response()->success(new ProductResource(Product::all()));
    }

}
