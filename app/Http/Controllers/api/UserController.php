<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\me\MeUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->success($users);
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

    public function update(MeUpdateRequest $request, User $user)
    {
        $input = $request->validated();

        if(!Hash::check($input['confirm_password'],$user->password)){
            return response()->error("Wrong Password");
        }

        $user->email = $input['email'];

        $userProfile = $user->profile;

        $userProfile->firstname  = $input['firstname'];
        $userProfile->middlename = $input['middlename'];
        $userProfile->lastname   = $input['lastname'];
        $userProfile->address    = $input['address'];
        $userProfile->contact_no = $input['contact_no'];

        if($user->isDirty()){
            $user->save();
        }

        $userProfile->save();

        return response()->success('Updated');
    }

}
