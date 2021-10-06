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
            'email'      => $this->email,
            'firstname'  => $this->profile->firstname,
            'middlename' => $this->profile->middlename,
            'lastname'   => $this->profile->lastname,
            'address'    => $this->profile->address,
            'contact_no' => $this->profile->contact_no
        ];
    }
}