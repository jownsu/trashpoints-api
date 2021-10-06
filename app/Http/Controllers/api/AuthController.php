<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $input = $request->validated();

        $user = User::create([
            'email' => $input['email'],
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

        return response()->success(['user' => $user,'token' => $token], 201);
    }

    public function login(LoginRequest $request){
        $input = $request->validated();

        $user = User::where('email', $input['email'])->first();

        if(!$user || !Hash::check($input['password'] ,$user->password)){

            return response()->error('Incorrect Email/Password', 401);
        }

        $token = $user->createToken('TrashPointsToken')->plainTextToken;

        return response()->success(['email' => $user->email, 'token' => $token, 'message' => 'Logged In'], 201);

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->success(['message' => 'Logged Out']);
    }
}
