<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    protected function isOwnedByUser($action, $model)
    {
        if(auth()->user()->can($action, $model)){
            return true;
        }
    }


}
