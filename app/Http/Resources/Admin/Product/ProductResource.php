<?php

namespace App\Http\Resources\Admin\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'category'      => $this->productCategory->name,
            'name'          => $this->name,
            'description'   => $this->description,
            'price'         => $this->price,
            'quantity'      => $this->quantity,
            'image'         => $this->image,
        ];
    }
}
