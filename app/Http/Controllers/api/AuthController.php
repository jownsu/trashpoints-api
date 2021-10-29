<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\ChangePasswordRequest;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Haruncpi\LaravelIdGenerator\IdGenerator;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $input = $request->validated();

        $user = User::create([
            'id'       => IdGenerator::generate(['table' => 'users', 'length' => 11, 'prefix' => date('Yis')]),
            'email'    => $input['email'],
            'password' => bcrypt($input['password'])
        ]);

        $user->profile()->create([
            'firstname'          => $input['firstname'],
            'middlename'         => $input['middlename'] ?? null,
            'lastname'           => $input['lastname'],
            'address'            => $input['address'],
            'contact_no'         => $input['contact_no'],
        ]);


        $token = $user->createToken('TrashPointsToken')->plainTextToken;
        $userData = new UserResource($user);

        return response()->success(['user' => $userData,'token' => $token, 'message' => 'Logged In'], 201);
    }

    public function login(LoginRequest $request){
        $input = $request->validated();

        $user = User::where('email', $input['email'])->first();

        if(!$user || !Hash::check($input['password'] ,$user->password)){

            return response()->error('Incorrect Email/Password', 401);
        }

        $token = $user->createToken('TrashPointsToken')->plainTextToken;
//        $userData = new UserResource($user);

        return response()->success(['user' => $user->id, 'token' => $token, 'message' => 'Logged In'], 201);

    }

    public function changePassword(ChangePasswordRequest $request){
        $input = $request->validated();

        $user = auth()->user();

        if(!Hash::check($input['current_password'],$user->password)){
            return response()->error("Wrong Password");
        }

        $user->password = bcrypt($input['new_password']);

        $user->save();

        return response()->success(['message' => "Password Changed"]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->success(['message' => 'Logged Out']);
    }
}
