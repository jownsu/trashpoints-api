<?php

namespace App\Http\Resources\User\Collect;

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
            'id'          => $this->id,
            'smug_id'     => $this->getSmugId(),
            'name'        => $this->name,
            'points'      => $this->pivot->points,
            'image'       => $this->image,
            'quantity'    => $this->pivot->quantity,
            'total_price' => $this->pivot->points * $this->pivot->quantity
        ];
    }
}
