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

        return [
            'id'             => $this->id,
            'smug_id'       => $this->getSmugId(),
            'total_item'     => $this->products->sum('pivot.quantity'),
            'total_price'    => $this->products->map(function($item){
                                    return $item->pivot->price * $item->pivot->quantity;
                                })->sum(),
            'checked_out_at' => $this->created_at->format('m/d/Y')
        ];
    }
}
