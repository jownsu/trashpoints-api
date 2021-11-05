<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrashCategoryRequest;
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
    public function index()
    {
        $categories = TrashCategory::all();

        return response()->success($categories);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TrashCategory $trashCategory)
    {
        return response()->success($trashCategory->trashes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrashCategory $trashCategory)
    {
        Storage::delete($trashCategory->image);
        $trashCategory->delete();
        return response()->success('deleted');
    }
}
