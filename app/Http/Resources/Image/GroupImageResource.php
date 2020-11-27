<?php

namespace App\Http\Resources\Image;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupImageResource extends JsonResource
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
            'image_id'=>$this->id,
            'image'=>asset('public/images/group/'.$this->image),
        ];
    }

}
