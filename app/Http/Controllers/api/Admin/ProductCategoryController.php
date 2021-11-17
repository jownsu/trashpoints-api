<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Http\Resources\Admin\Product\CategoryResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TrashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = ProductCategory::query();

        if($request->has('search')){
            $categories->where('name', 'LIKE', '%'. $request->search .'%');
        }

        if($request->has('per_page')){
            $data = CategoryResource::collection($categories->paginate($request->per_page))
                ->response()
                ->getData(true);
            return response()->successWithPaginate($data);
        }

        return response()->success(CategoryResource::collection($categories->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request)
    {
        $category = new ProductCategory($request->validated());
        if($request->hasFile('image')){
            $category->image = $request->image->store(ProductCategory::PRODUCT_CATEGORY_IMG_PATH);
        }
        $category->save();
        return response()->success($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $request->has('search')
            ? $products = Product::where('product_category_id', $id)
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->get()
            : $products = Product::where('product_category_id', $id)->get();

        return response()->success($products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $input = $request->validated();
        if($request->hasFile('image')){
            Storage::delete($productCategory->image);
            $input['image'] = $request->image->store(ProductCategory::PRODUCT_CATEGORY_IMG_PATH);
        }
        $productCategory->update($input);
        return response()->success($productCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        Storage::delete($productCategory->image);
        $productCategory->delete();
        return response()->success('deleted');
    }
}
