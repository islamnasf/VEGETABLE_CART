<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class orderResource extends JsonResource
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
            'user_id'=> $this->user_id,
            'user_name'=> $this->user_name,
            'user_phone'=> $this->user_phone,
            'total_price'=> $this->total_price,
            'user_address'=> $this->user_address,
            'notes'=> $this->notes,
            'code'=> $this->code,
            'payment_method'=> $this->payment_method,
            'day'=> $this->day,
            'houre'=> $this->houre,
            'orders'=>orderDetailsResource::collection($this->orders),



        ];
    }
}
