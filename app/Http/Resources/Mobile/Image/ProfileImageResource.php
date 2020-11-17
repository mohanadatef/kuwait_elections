<?php

namespace App\Http\Resources\Mobile\Image;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileImageResource extends JsonResource
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
            'image_profile_id'=>$this->id,
            'image'=>asset('public/images/user/profile/'.$this->image),
        ];
    }

}
