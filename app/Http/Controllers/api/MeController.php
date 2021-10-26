<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\me\MeUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $id = auth()->id();

        return redirect('api/users/'.$id);
    }

    public function uploadavatar(Request $request)
    {
        $user = auth()->user();

        $userProfile = $user->profile;

        if($request->hasFile('avatar')){
            Storage::delete($user->profile->avatar);

            $userProfile->avatar = $request->avatar->store('');
            $userProfile->save();
        }

        return response()->success('Avatar Updated');
    }

}
