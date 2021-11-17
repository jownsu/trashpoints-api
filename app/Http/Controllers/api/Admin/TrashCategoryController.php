<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrashCategoryRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\Trash\CategoryResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Trash;
use App\Models\TrashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrashCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = TrashCategory::query();

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
    public function store(TrashCategoryRequest $request)
    {
        $category = new TrashCategory($request->validated());
        if($request->hasFile('image')){
            $category->image = $request->image->store(TrashCategory::TRASH_CATEGORY_IMG_PATH);
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
            ? $trashes = Trash::where('trash_category_id', $id)
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->get()
            : $trashes = Trash::where('trash_category_id', $id)->get();

        return response()->success($trashes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(TrashCategoryRequest $request, TrashCategory $trashCategory)
    {
        $input = $request->validated();
        if($request->hasFile('image')){
            Storage::delete($trashCategory->image);
            $input['image'] = $request->image->store(TrashCategory::TRASH_CATEGORY_IMG_PATH);
        }
        $trashCategory->update($input);
        return response()->success($trashCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrashCategory $trashCategory)
    {
        Storage::delete($trashCategory->image);
        $trashCategory->delete();
        return response()->success('deleted');
    }
}
