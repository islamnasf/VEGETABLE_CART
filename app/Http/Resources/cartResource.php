<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class cartResource extends JsonResource
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
       
            'id'=>$this->id,
            'user_id'=> $this->user_id,
            'product_id'=>$this->product_id,
            'quantity'=> $this->quantity,
            'products'=> productResource::make($this->products),

        ];
    }
}
