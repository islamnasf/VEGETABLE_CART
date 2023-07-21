<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class orderDetailsResource extends JsonResource
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
            'allOrder_id'=>$this->allOrder_id,
            'product_id'=>$this->product_id,
            'image'=>$this->products->image,
            'product_name'=>$this->products->name,
            'quantity'=>$this->quantity,
        ];
    }
}
