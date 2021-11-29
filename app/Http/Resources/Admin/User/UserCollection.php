<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
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
            'id'         => $this->id,
            'smug_id'    => $this->getSmugId(),
            'fullname'   => $this->profile->fullname(),
            'email'      => $this->email,
            'address'    => $this->profile->address,
            'contact_no' => $this->profile->contact_no,
            'is_admin'   => $this->is_admin,
            'avatar'     => $this->profile->avatar,
        ];
    }
}
