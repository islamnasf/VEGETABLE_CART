<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class productResource extends JsonResource
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
            'product_id'=>$this->id,
            'name'=>$this->name,
            'image'=>$this->image,
            'category_id'=> $this->category_id,
            'price'=> $this->price,
            'discount'=> $this->discount,
            'description'=> $this->description,
            'code'=> $this->code,
            'weight'=> $this->weight,
            'photos'=>photoResource::collection($this->photos),
        ];
    }
}
