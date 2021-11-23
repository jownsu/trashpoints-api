<?php

namespace App\Http\Resources\User\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'             => $this->id,
            'products'       => ProductResource::collection($this->products),
            'checked_out_at' => $this->created_at->format('m/d/Y'),
            'total'          => $total_price
        ];
    }
}
