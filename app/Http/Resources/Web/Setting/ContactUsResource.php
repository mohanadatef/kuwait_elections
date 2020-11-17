<?php

namespace App\Http\Resources\Web\Setting;

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
            'address'=>$this->address,
            'time_work'=>$this->time_work,
            'map_latitude'=>$this->latitude,
            'map_longitude'=>$this->longitude,
            'phone'=>$this->phone,
            'email'=>$this->email,
        ];
    }
}
