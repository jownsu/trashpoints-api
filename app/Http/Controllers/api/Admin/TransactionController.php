<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\api\ApiController;
use App\Http\Resources\Admin\Transaction\TransactionCollection;
use App\Http\Resources\Admin\Transaction\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = Transaction::with(['user.profile']);

        if($request->has('search')){
            if(is_numeric($request->search)){
                $transactions->whereHas('user', function($query) use($request){
                    $query->where('id', 'LIKE', '%' . $request->search . '%');
                });
            }else{
                $transactions->whereHas('user.profile', function($query) use($request){
                    $query->where('firstname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('middlename', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $request->search . '%');
                });
            }
        }

        if($request->has('per_page') && is_numeric($request->per_page)){

            $total = $transactions->count();
            $paginationData = $this->paginate($total);

            $transactions->offset(($paginationData['current_page'] - 1) * $paginationData['per_page'])
                         ->limit($paginationData['per_page']);

            $data = TransactionCollection::collection($transactions->get());
            return response()->successWithPaginate($data, $paginationData);
        }

        return  response()->success( TransactionCollection::collection($transactions->get()));

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
    public function show(Transaction $transaction)
    {
        $transaction->load(['products', 'user.profile']);

        return response()->success(new TransactionResource($transaction));
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

    public function total()
    {
        return response()->success($this->pivotTotal('product_transaction', 'total_pending_points', 'price'));
    }

}
