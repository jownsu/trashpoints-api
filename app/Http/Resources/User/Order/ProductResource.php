<?php

namespace App\Http\Resources\User\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id'          => $this->id,
            'smug_id'       => $this->getSmugId(),
            'name'        => $this->name,
            'price'       => $this->price,
            'image'       => $this->image,
            'quantity'    => $this->pivot->quantity,
            'total_price' => $this->pivot->price * $this->pivot->quantity
        ];
    }
}
