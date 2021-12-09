<?php

namespace App\Http\Resources\User\Collect;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectCollection extends JsonResource
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
            'smug_id'        => $this->getSmugId(),
            'total_item'     => $this->trashes->sum('pivot.quantity'),
            'total_points'    => $this->trashes->map(function($item){
                                    return $item->pivot->points * $item->pivot->quantity;
                                })->sum(),
            'collected_at' => $this->created_at->format('m/d/Y')
        ];
    }
}
