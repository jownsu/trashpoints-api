<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class UserOrderResource extends JsonResource
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
            'id'            => $this->id,
            'user_name'     => $this->user->profile->fullname(),
            'user_email'    => $this->user->email,
            'user_avatar'   => $this->user->profile->avatar,
            'products'      => ProductResource::collection($this->products),
            'total'         => $total_price
        ];
    }
}
