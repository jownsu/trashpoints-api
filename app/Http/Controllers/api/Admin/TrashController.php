<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrashCategoryRequest;
use App\Http\Requests\TrashRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\Trash\CategoryListResource;
use App\Http\Resources\Admin\Trash\TrashResource;
use App\Models\ProductCategory;
use App\Models\Trash;
use App\Models\TrashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrashController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $trashes = Trash::query()->with('trashCategory');


        if($request->has('category') && !empty($request->category)){
            $trashes->where('trash_category_id', $request->category);
        }

        if($request->has('filter') && $request->filter == 'true'){
            return response()->success(
                CategoryListResource::collection($trashes->get())
                    ->prepend(['id' => 0, 'name' => 'All']));
        }

        if($request->has('search')){
            $trashes->where('name', 'LIKE', '%'. $request->search .'%');
        }

        if($request->has('per_page') && is_numeric($request->per_page)){

            $total = $trashes->count();
            $paginationData = $this->paginate($total);

            $trashes->offset(($paginationData['current_page'] - 1) * $paginationData['per_page'])
                    ->limit($paginationData['per_page']);

            $data = TrashResource::collection($trashes->get());
            return response()->successWithPaginate($data, $paginationData);
        }

        return response()->success(TrashResource::collection($trashes->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrashRequest $request)
    {
        $trash = new Trash($request->validated());
        if($request->hasFile('image')){
            $trash->image = $request->image->store(Trash::TRASHES_IMG_PATH);
        }
        $trash->save();
        return response()->success(new TrashResource($trash));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Trash $trash)
    {
        return response()->success(new TrashResource($trash));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */

    public function update(TrashRequest $request, Trash $trash)
    {
        $input = $request->validated();
        if($request->hasFile('image')){
            Storage::delete($trash->image);
            $input['image'] = $request->image->store(Trash::TRASHES_IMG_PATH);
        }
        $trash->update($input);
        return response()->success($trash);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trash $trash)
    {
        Storage::delete($trash->image);
        $trash->delete();
        return response()->success('deleted');
    }
}
