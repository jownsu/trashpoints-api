<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $totalearned = $this->collects->map(function($collection){
            return $collection->trashes->map(function($item){
                return $item->points * $item->pivot->quantity;
            })->sum();
        })->sum();

        $totalSpend = $this->transactions->map(function($collection){
            return $collection->products->map(function($item){
                return $item->price * $item->pivot->quantity;
            })->sum();
        })->sum();

        $balance = $totalearned - $totalSpend;

        return [
            'id'         => $this->id,
            'smug_id'    => $this->getSmugId(),
            'fullname'   => $this->profile->fullname(),
            'email'      => $this->email,
            'firstname'  => $this->profile->firstname,
            'middlename' => $this->profile->middlename ?? '',
            'lastname'   => $this->profile->lastname,
            'address'    => $this->profile->address,
            'contact_no' => $this->profile->contact_no,
            'is_admin'   => $this->is_admin,
            'balance'    => $balance,
            'avatar'     => $this->profile->avatar,
        ];

    }
}
