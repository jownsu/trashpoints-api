<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Requests\StoreCollectRequest;
use App\Models\Collect;
use App\Models\User;
use Illuminate\Http\Request;

class CollectController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCollectRequest $request)
    {
        $input = $request->validated();
        $userId = $input['user_id'];

        if(!User::where('id', $userId)->exists()){
            return response()->error('User not found');
        }

        $collect = new Collect(['user_id' => $userId]);

        if($collect->save()){
            $collect->trashes()->attach($input['trashes']);
        }

        return response()->success($collect);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
