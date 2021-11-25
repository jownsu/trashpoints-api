<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Admin\Product\ProductResource;
use App\Http\Resources\Admin\TrashResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Trash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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


        if($request->has('category')){
            $products->where('product_category_id', $request->category);
        }

        if($request->has('search')){
            $products->where('name', 'LIKE', '%'. $request->search .'%');
        }

//        if($request->has('per_page') && is_numeric($request->per_page)){
//            $data = ProductResource::collection($products->paginate($request->per_page))
//                ->response()
//                ->getData(true);
//            return response()->successWithPaginate($data);
//        }

        if($request->has('per_page') && is_numeric($request->per_page)){
            $page = ($request->has('page') && is_numeric($request->page))
                ? $request->page
                : 1;

            $per_page = $request->per_page;

            $total = $products->count();
            $total_pages = ceil($total / $per_page);
            $products->offset(($page - 1) * $per_page)->limit($per_page);

            return response([
                'data'         => ProductResource::collection($products->get()),
                'total_pages'  => $total_pages,
                'current_page' => (int) $page,
                'has_next'     => ($page < $total_pages) ? true : false,
                'has_prev'     => ($page > 1 ) ? true : false
            ]);
        }

        return response()->success(ProductResource::collection($products->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product($request->validated());
        if($request->hasFile('image')){
            $product->image = $request->image->store(Product::PRODUCTS_IMG_PATH);
        }
        $product->save();
        return response()->success($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->success($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $input = $request->validated();
        if($request->hasFile('image')){
            Storage::delete($product->image);
            $input['image'] = $request->image->store(Product::PRODUCTS_IMG_PATH);
        }
        $product->update($input);
        return response()->success($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Storage::delete($product->image);
        $product->delete();
        return response()->success('deleted');
    }
}
