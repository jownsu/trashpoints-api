<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Http\Resources\Admin\Product\CategoryListResource;
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

        if($request->has('filter') && $request->filter == 'true'){
            return response()->success(
                CategoryListResource::collection($categories->get())
                    ->prepend(['id' => 0, 'name' => 'All']));
        }

        if($request->has('search')){
            $categories->where('name', 'LIKE', '%'. $request->search .'%');
        }

        if($request->has('per_page') && is_numeric($request->per_page)){
            $page = ($request->has('page') && is_numeric($request->page))
                ? $request->page
                : 1;

            $per_page = $request->per_page;

            $total = $categories->count();
            $total_pages = ceil($total / $per_page);

            $pages = [];

            for ($i=1; $i <= $total_pages; $i++){
                array_push($pages, $i);
            }

            $categories->offset(($page - 1) * $per_page)->limit($per_page);

            return response([
                'data'         => CategoryResource::collection($categories->get()),
                'pages'        => $pages,
                'current_page' => (int) $page,
                'has_next'     => ($page < $total_pages) ? true : false,
                'has_prev'     => ($page > 1 ) ? true : false
            ]);
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
    public function show(ProductCategory $productCategory)
    {
        return response()->success(new CategoryResource($productCategory));
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
