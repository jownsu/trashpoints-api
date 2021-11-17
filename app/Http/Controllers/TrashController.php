<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrashRequest;
use App\Models\Trash;
use App\Models\TrashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TrashController extends Controller
{

    public function index()
    {
        $trashes = Trash::with('trashCategory')->get();
        $categories = TrashCategory::all();
        return view('admin.manage_trashes', ['trashes' => $trashes, 'categories' => $categories]);
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


    public function store(TrashRequest $request)
    {
        $trash = new Trash($request->validated());
        if($request->hasFile('image')){
            $trash->image = $request->image->store(Trash::TRASHES_IMG_PATH);
        }
        $trash->save();

        return redirect('admin/trashes')->with('success', 'Trash Added');
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


    public function destroy(Trash $trash)
    {
        Storage::delete($trash->image);
        $trash->delete();
        return redirect('admin/trashes')->with('delete', 'Trash Deleted');
    }
}
