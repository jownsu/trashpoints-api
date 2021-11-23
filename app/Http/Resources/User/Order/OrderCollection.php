<?php

namespace App\Http\Resources\User\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $total_price = 0;
        $item_count = 0;
        foreach($this->products as $product){
            $total_price += $product->price * $product->pivot->quantity;
            $item_count++;
        }

        return [
            'id'             => $this->id,
            'total_item'     => $item_count,
            'total_price'    => $total_price,
            'checked_out_at' => $this->created_at->format('m/d/Y')
        ];
    }
}
