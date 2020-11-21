<?php

namespace App\Http\Resources\Mobile\Social_Media\Group;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->image)
        {
        return [
            'group_id'=>$this->id,
            'title'=>$this->title,
            'profile_image'=> asset('public/images/group/'.$this->image->image),
        ];
        }
        return [
            'group_id'=>$this->id,
            'title'=>$this->title,
            'profile_image'=> asset('public/images/user/profile/profile_user.jpg'),
        ];
    }

}
