<?php

namespace App\Http\Resources\User\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'smug_id'       => $this->getSmugId(),
            'products' => $this->products->first()->only(['id', 'name', 'description', 'information', 'price', 'image']),
            'quantity' => $this->quantity
        ];
    }
}
