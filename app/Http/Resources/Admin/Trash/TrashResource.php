<?php

namespace App\Http\Resources\Admin\Trash;

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
        return [
            'id'          =>  $this->id,
            'smug_id'     => $this->getSmugId(),
            'category_id' => $this->trashCategory->id,
            'category'    => $this->trashCategory->name,
            'name'        => $this->name,
            'points'      => $this->points,
            'unit'        => $this->unit,
            'image'       => $this->image,
        ];
    }
}
