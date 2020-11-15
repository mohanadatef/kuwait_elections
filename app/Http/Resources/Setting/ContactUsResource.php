<?php

namespace App\Http\Resources\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'key'=>$this->id,
            'address'=>$this->address,
            'time_work'=>$this->time_work,
            'map_latitude'=>$this->latitude,
            'map_longitude'=>$this->longitude,
            'phone'=>$this->phone,
            'email'=>$this->email,
        ];
    }
}
