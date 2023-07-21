<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class countryResource extends JsonResource
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
            'country_id'=>$this->id,
            'name'=>$this->name,
            'key'=>$this->key,
            'image'=>$this->image


        ];
    }
}
