<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = ProductCategory::all();
        return response()->success($category);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        return response()->success($productCategory->products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        Storage::delete($productCategory->image);
        $productCategory->delete();
        return response()->success('deleted');
    }
}
