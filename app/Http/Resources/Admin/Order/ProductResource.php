<?php

namespace App\Http\Resources\Admin\Order;

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
            'name'        => $this->name,
            'price'       => $this->price,
            'image'       => $this->image,
            'quantity'    => $this->pivot->quantity,
            'total_price' => $this->price * $this->pivot->quantity
        ];
    }
}
