<?php

namespace App\Http\Resources\Order;

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
        return [
            'id'                  => $this->id,
            'name'                => $this->user->profile->fullname(),
            'email'               => $this->user->email,
            'avatar'              => $this->user->profile->avatar,
            'product_name'        => $this->product->name,
            'product_description' => $this->product->description,
            'product_image'       => $this->product->image,
            'product_price'       => $this->product->price,
            'quantity'            => $this->quantity,
            'total_price'         => round($this->product->price * $this->quantity, 2)
        ];
    }
}
