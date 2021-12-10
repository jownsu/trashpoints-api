<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Requests\StoreCollectRequest;
use App\Http\Resources\Admin\Collect\CollectCollection;
use App\Http\Resources\Admin\Collect\CollectResource;
use App\Models\Collect;
use App\Models\Trash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CollectController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $collects = Collect::with(['user.profile']);

        if($request->has('search')){
            if(is_numeric($request->search)){
                $collects->whereHas('user', function($query) use($request){
                    $query->where('id', 'LIKE', '%' . $request->search . '%');
                });
            }else{
                $collects->whereHas('user.profile', function($query) use($request){
                    $query->where('firstname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('middlename', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $request->search . '%');
                });
            }
        }

        if($request->has('per_page') && is_numeric($request->per_page)){

            $total = $collects->count();
            $paginationData = $this->paginate($total);

            $collects->offset(($paginationData['current_page'] - 1) * $paginationData['per_page'])
                     ->limit($paginationData['per_page']);

            $data = CollectCollection::collection($collects->get());
            return response()->successWithPaginate($data, $paginationData);
        }

        return  response()->success( CollectCollection::collection($collects->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCollectRequest $request)
    {

        $trashIds = Arr::pluck($request->trashes, 'trash_id');
        $trashes = Trash::select('id as trash_id', 'points')->findOrFail($trashIds)->toArray();
        $resultSet = array_merge($trashes, $request->trashes);

        $collects_arr = [];

        foreach ($resultSet as $record) {
            $key = $record['trash_id'];
            if (array_key_exists($key, $collects_arr)) {
                $collects_arr[$key] = array_merge($collects_arr[$key], $record);
            }else{
                $collects_arr[$key] = $record;
            }
        }

        if(!User::where('id', $request->user_id)->exists()){
            return response()->error('User not found');
        }

        $collect = new Collect(['user_id' => $request->user_id]);

        if($collect->save()){
            $collect->trashes()->attach(array_values($collects_arr));
        }

        $total = $collect->trashes->map(function($item){
            return $item->pivot->points * $item->pivot->quantity;
        })->sum();

        return response()->success($total);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Collect $collect)
    {
        $collect->load(['trashes', 'user.profile']);

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

    public function total()
    {
        return response()->success($this->pivotTotal('collect_trash', 'total_distributed_points', 'points'));
    }
}
