<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\api\ApiController;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->has('search')
            ? $category = ProductCategory::where('name','LIKE' ,'%'. $request->search . '%')->get()
            : $category = ProductCategory::all();

        return response()->success($category);
    }

}
