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
        $products = Product::query()->with('productCategory');

        if($request->has('category') && !empty($request->category)){
            $products = $products->where('product_category_id', $request->category);
        }

        if($request->has('search')){
            $products->where('name', 'LIKE', '%'. $request->search .'%');
        }

        return response()->success( ProductResource::collection($products->get()));

        //return response()->success( ProductResource::collection(Product::all()));
    }

}
