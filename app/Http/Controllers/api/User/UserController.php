<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\api\ApiController;
use App\Http\Requests\auth\ChangePasswordRequest;
use App\Http\Requests\me\MeUpdateRequest;
use App\Http\Requests\UploadAvatarRequest;
use App\Http\Requests\User\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $data = new UserResource($user);
        return response()->success($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $user = auth()->user();

        if(!Hash::check($request->current_password,$user->password)){
            return response()->error("Wrong Password");
        }

        $user->email = $request->email;

        $userProfile = $user->profile;

        //$userProfile->firstname  = $input['firstname'];
        //$userProfile->middlename = $input['middlename'];
        //$userProfile->lastname   = $input['lastname'];
        //$userProfile->address    = $input['address'];
        //$userProfile->contact_no = $input['contact_no'];

        $userProfile->update($request->validated());

        if($user->isDirty()){
            $user->save();
        }

        //$userProfile->save();

        return response()->success(new UserResource($user));
    }

    public function uploadavatar(UploadAvatarRequest $request)
    {
        $input = $request->validated();

        $user = auth()->user();

        $userProfile = $user->profile;

        Storage::delete($user->profile->avatar);
        $userProfile->avatar = $input['avatar']->store(Profile::AVATARS_IMG_PATH);
        $userProfile->save();

        return response( )->success(new UserResource($user));
    }

    public function changePassword(ChangePasswordRequest $request){
        $user = auth()->user();

        if(!Hash::check($request->current_password ,$user->password)){
            return response()->error("Wrong Password");
        }

        $user->password = bcrypt($request->new_password);

        $user->save();

        return response()->success(new UserResource($user));
    }
}
