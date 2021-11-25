<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $request->has('search')
//            ? $users = User::where('email','LIKE' ,'%'. $request->search . '%')->with('profile')->get()
//            : $users = User::with('profile')->get();

        $users = User::query()->with('profile');

        if($request->has('search')){
            $users->where('id', 'LIKE', '%'. $request->search .'%');
        }

//        if($request->has('per_page') && is_numeric($request->per_page)){
//            $data = UserResource::collection($users->paginate($request->per_page))
//                ->response()
//                ->getData(true);
//            return response()->successWithPaginate($data);
//        }

        if($request->has('per_page') && is_numeric($request->per_page)){
            $page = ($request->has('page') && is_numeric($request->page))
                    ? $request->page
                    : 1;

            $per_page = $request->per_page;

            $total = $users->count();
            $total_pages = ceil($total / $per_page);
            $users->offset(($page - 1) * $per_page)->limit($per_page);

            return response([
                'data'         => UserResource::collection($users->get()),
                'total_pages'  => $total_pages,
                'current_page' => (int) $page,
                'has_next'     => ($page < $total_pages) ? true : false,
                'has_prev'     => ($page > 1 ) ? true : false
            ]);
        }

        return response()->success(UserResource::collection($users->get()));

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
        $user = new UserResource($user);

        return response()->success($user);
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
