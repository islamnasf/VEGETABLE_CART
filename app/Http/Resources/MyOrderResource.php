<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyOrderResource extends JsonResource
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
            'status'=> $this->status,
            'id'=> $this->id,
            'delivery_id'=> $this->delivery_id,
            'allOrder_id'=> $this->allOrder_id,
            'paid'=> $this->paid,
            'money'=> $this->money,
            'all_orders'=>orderResource::make($this->all_orders),
        ];
    }
}
