<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\api\ApiController;
use App\Http\Resources\User\Trash\TrashResource;
use App\Models\Trash;
use Illuminate\Http\Request;

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

        if($request->has('category')){
            $trashes = $trashes->where('trash_category_id', $request->category);

            if($request->has('search')){
                $trashes->where('name', 'LIKE', '%'. $request->search .'%');
            }

            return response()->success( TrashResource::collection($trashes->get()) );
        }

        return response()->success( TrashResource::collection(Trash::all()) );
    }

}
