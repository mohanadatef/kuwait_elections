<?php

namespace App\Http\Resources\Takeed\Core_Data;

use Illuminate\Http\Resources\Json\JsonResource;

class CircleResource extends JsonResource
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
            'title'=>$this->title,
        ];
    }
}
