<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\api\ApiController;
use App\Http\Resources\User\Collect\CollectCollection;
use App\Http\Resources\User\Collect\CollectResource;
use App\Http\Resources\User\Transaction\TransactionResource;
use App\Models\Collect;
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
        $collects = Collect::where('user_id', auth()->id())->with('trashes')->get();
        return response()->success(CollectCollection::collection($collects));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Collect $collect)
    {
        if(!$this->isOwnedByUser('view', $collect)){
            return response()->error('This collection is not owned by user');
        }
        $collect->load('trashes');

        //return response()->success(new OrderResource($order));
        return response()->success(new CollectResource($collect));
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
