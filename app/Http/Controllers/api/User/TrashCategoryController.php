<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\api\ApiController;
use App\Models\TrashCategory;
use Illuminate\Http\Request;

class TrashCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $request->has('search')
            ? $categories = TrashCategory::where('name','LIKE' ,'%'. $request->search . '%')->get()
            : $categories = TrashCategory::all();

        return response()->success($categories);
    }
}
