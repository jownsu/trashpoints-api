<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TrashResource extends JsonResource
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
            'price'       => $this->points,
            'image'       => $this->image,
            'quantity'    => $this->pivot->quantity,
            'total_price' => $this->pivot->points * $this->pivot->quantity
        ];
    }
}
