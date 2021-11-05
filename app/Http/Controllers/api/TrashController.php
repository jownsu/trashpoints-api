<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trash\StoreTrashRequest;
use App\Http\Requests\TrashRequest;
use App\Models\Profile;
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
    public function index()
    {
        $trashes = Trash::all();

        return response()->success($trashes);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Trash $trash)
    {
        return response()->success($trash);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trash $trash)
    {
        Storage::delete($trash->image);
        $trash->delete();
        return response()->success('deleted');
    }
}
