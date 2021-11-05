<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\StoreWalletRequest;
use App\Models\Wallet;
use Illuminate\Http\Request;

class UserWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function addPoints(StoreWalletRequest $request)
    {
        $input = $request->validated();

        $wallet = Wallet::getWalletByUser($input['user_id']);

        if($wallet->addPoints($input['points'])){
            return response()->success('Points credited');
        }else{
            return response()->error('Something went wrong');
        }
    }

    public function pay()
    {

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
}
