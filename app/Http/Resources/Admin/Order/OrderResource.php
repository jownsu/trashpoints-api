<?php

namespace App\Http\Resources\Admin\Order;

use App\Http\Resources\Admin\Order\ProductResource;
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
            'id'            => $this->id,
            'smug_id'       => $this->getSmugId(),
            'user_id'       => $this->user->id,
            'smug_user_id'  => $this->user->getSmugId(),
            'user_name'     => $this->user->profile->fullname(),
            'user_email'    => $this->user->email,
            'user_avatar'   => $this->user->profile->avatar,
            'products'      => ProductResource::collection($this->products),
            'total_item'    => $this->products->sum('pivot.quantity'),
            'total_price'   => $this->products->map(function($item){
                                    return $item->price * $item->pivot->quantity;
                                })->sum(),
            'checked_out_at' => $this->created_at->format('m/d/Y')
        ];
    }
}
