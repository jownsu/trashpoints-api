<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Resources\Admin\User\UserCollection;
use App\Http\Resources\Admin\User\UserResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$users = User::join('profiles', 'users.id', '=', 'profiles.user_id');

        $users = User::with('profile');

        if($request->has('search')){
            $users->where('id', 'LIKE', '%'. $request->search .'%')
                ->orWhere('email', 'LIKE', '%'. $request->search .'%');
        }

        if($request->has('per_page') && is_numeric($request->per_page)){

            $total = $users->count();
            $paginationData = $this->paginate($total);

            $users->offset(($paginationData['current_page'] - 1) * $paginationData['per_page'])
                  ->limit($paginationData['per_page']);

            $data = UserResource::collection($users->get());
            return response()->successWithPaginate($data, $paginationData);
        }

        //return response()->success(UserResource::collection($users->get()));
        return response()->success(UserCollection::collection($users->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->success(new UserResource($user));
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
        $total = User::all()->count();

        return response()->success(['total_users' => $total]);
    }
}
