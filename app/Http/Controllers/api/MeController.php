<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\me\MeUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

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

}
