<?php

namespace App\Http\Resources\User\Collect;

use App\Http\Resources\User\Order\ProductResource;
use App\Http\Resources\User\Collect\TrashResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectResource extends JsonResource
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
            'id'              => $this->id,
            'smug_id'         => $this->getSmugId(),
            'products'        => TrashResource::collection($this->trashes),
            'collected_at'    => $this->created_at->format('m/d/Y'),
            'total'           => $this->trashes->map(function($item){
                                    return $item->pivot->points * $item->pivot->quantity;
                                })->sum()
        ];
    }
}
