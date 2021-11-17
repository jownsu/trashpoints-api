<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Http\Requests\TrashCategoryRequest;
use App\Models\ProductCategory;
use App\Models\TrashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function index()
    {
        $trash_categories = TrashCategory::all();
        $product_categories = ProductCategory::all();
        return view('admin.manage_categories', ['trash_categories' => $trash_categories, 'product_categories' => $product_categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addProductCategory(ProductCategoryRequest $request)
    {
        $category = new ProductCategory($request->validated());
        if($request->hasFile('image')){
            $category->image = $request->image->store(ProductCategory::PRODUCT_CATEGORY_IMG_PATH);
        }
        $category->save();

        return redirect(route('categories'))->with('success', 'Product Category Added');
    }

    public function addTrashCategory(TrashCategoryRequest $request)
    {
        $category = new TrashCategory($request->validated());
        if($request->hasFile('image')){
            $category->image = $request->image->store(TrashCategory::TRASH_CATEGORY_IMG_PATH);
        }
        $category->save();

        return redirect(route('categories'))->with('success', 'Trash Category Added');
    }

    public function deleteProductCategory($id)
    {
        $productCategory = ProductCategory::findOrFail($id);
        Storage::delete($productCategory->image);
        $productCategory->delete();
        return redirect('admin/categories')->with('delete', 'Product Category Deleted');
    }

    public function deleteTrashCategory($id)
    {
        $trashCategory = TrashCategory::findOrFail($id);
        Storage::delete($trashCategory->image);
        $trashCategory->delete();
        return redirect('admin/categories')->with('delete', 'Trash Category Deleted');
    }
}
