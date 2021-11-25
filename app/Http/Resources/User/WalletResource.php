<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
/*        return [
            'balance' => $this->balance
        ];*/
        $trashPoints = 0;

        foreach ($this->trashes as $trash){
            $trashPoints += $trash->points * $trash->pivot->quantity;
        }

        return [
            'id'    => $this->id,

        ];
    }
}
