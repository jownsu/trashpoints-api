<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrashCategoryRequest;
use App\Http\Requests\TrashRequest;
use App\Http\Resources\Admin\ProductResource;
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

        if($request->has('search')){
            $trashes->where('name', 'LIKE', '%'. $request->search .'%');
        }

//        if($request->has('per_page') && is_numeric($request->per_page)){
//            $data = TrashResource::collection($trashes->paginate($request->per_page))
//                ->response()
//                ->getData(true);
//            return response()->successWithPaginate($data);
//        }

        if($request->has('per_page') && is_numeric($request->per_page)){
            $page = ($request->has('page') && is_numeric($request->page))
                ? $request->page
                : 1;

            $per_page = $request->per_page;

            $total = $trashes->count();
            $total_pages = ceil($total / $per_page);

            $pages = [];

            for ($i=1; $i <= $total_pages; $i++){
                array_push($pages, $i);
            }

            $trashes->offset(($page - 1) * $per_page)->limit($per_page);

            return response([
                'data'         => TrashResource::collection($trashes->get()),
                'pages'        => $pages,
                'current_page' => (int) $page,
                'has_next'     => ($page < $total_pages) ? true : false,
                'has_prev'     => ($page > 1 ) ? true : false
            ]);
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
        return response()->success($trash);
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
