<?php

namespace App\Http\Resources\Mobile\Image;

use Illuminate\Http\Resources\Json\JsonResource;

class PostImageResource extends JsonResource
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
            'image_post_id'=>$this->id,
            'image'=>asset('public/images/post/'.$this->image),
        ];
    }

}
