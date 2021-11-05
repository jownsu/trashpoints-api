<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\me\MeUpdateRequest;
use App\Http\Requests\UploadAvatarRequest;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $user = auth()->user();
        $data = new UserResource($user);
        return response()->success($data);
    }

    public function uploadavatar(UploadAvatarRequest $request)
    {
        $input = $request->validated();

        $user = auth()->user();

        $userProfile = $user->profile;

        Storage::delete($user->profile->avatar);
        $userProfile->avatar = $input['avatar']->store(Profile::AVATARS_IMG_PATH);
        $userProfile->save();

        return response( )->success('Avatar Updated');
    }

}
