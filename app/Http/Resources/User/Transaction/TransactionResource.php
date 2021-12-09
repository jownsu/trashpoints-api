<?php

namespace App\Http\Resources\User\Transaction;

use App\Http\Resources\User\Order\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $total_price = 0;
        foreach($this->products as $product){
            $total_price += $product->price * $product->pivot->quantity;
        }

        return [
            'id'              => $this->id,
            'smug_id'         => $this->getSmugId(),
            'products'        => ProductResource::collection($this->products),
            'transtracted_at' => $this->created_at->format('m/d/Y'),
            'total'           => $total_price
        ];
    }
}
