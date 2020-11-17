<?php

namespace App\Http\Resources\Mobile\Core_Data;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
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
            'area_id'=>$this->id,
            'title'=>$this->title,
        ];
    }
}
