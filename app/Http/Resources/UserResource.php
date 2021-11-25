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
        return [
            'id'         => $this->id,
            'fullname'   => $this->profile->fullname(),
            'email'      => $this->email,
            'firstname'  => $this->profile->firstname,
            'middlename' => $this->profile->middlename ?? '',
            'lastname'   => $this->profile->lastname,
            'address'    => $this->profile->address,
            'contact_no' => $this->profile->contact_no,
            'is_admin'   => $this->is_admin,
            'balance'    => $this->balance(),
            'avatar'     => $this->profile->avatar
        ];
    }
}
