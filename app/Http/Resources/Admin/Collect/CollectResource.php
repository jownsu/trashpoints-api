<?php

namespace App\Http\Resources\Admin\Collect;

use App\Http\Resources\Admin\TrashResource;
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
            'id'            => $this->id,
            'smug_id'       => $this->getSmugId(),
            'user_id'       => $this->user->id,
            'smug_user_id'  => $this->user->getSmugId(),
            'user_name'     => $this->user->profile->fullname(),
            'user_email'    => $this->user->email,
            'user_avatar'   => $this->user->profile->avatar,
            'trashes'       => TrashResource::collection($this->trashes),
            'total_item'    => $this->trashes->sum('pivot.quantity'),
            'total_price'   => $this->trashes->map(function($item){
                                return $item->pivot->points * $item->pivot->quantity;
                            })->sum(),
            'collected_at' => $this->created_at->format('m/d/Y')
        ];
    }
}
