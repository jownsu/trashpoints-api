<?php

namespace App\Http\Resources\Admin\User;

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
        $total_earned = $this->getTotalEarned();
        $total_spent = $this->getTotalSpent();
        $total_pending = $this->getTotalPending();
        $balance = $total_earned - ( $total_spent + $total_pending );

        return [
            'id'             => $this->id,
            'smug_id'        => $this->getSmugId(),
            'fullname'       => $this->profile->fullname(),
            'email'          => $this->email,
            'firstname'      => $this->profile->firstname,
            'middlename'     => $this->profile->middlename ?? '',
            'lastname'       => $this->profile->lastname,
            'address'        => $this->profile->address,
            'contact_no'     => $this->profile->contact_no,
            'is_admin'       => $this->is_admin,
            'total_earned'   => $total_earned,
            'total_spent'    => $total_spent,
            'total_pending'  => $total_pending,
            'balance'        => $balance,
            'avatar'         => $this->profile->avatar,
        ];
    }
}
