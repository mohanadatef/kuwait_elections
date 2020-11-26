<?php

namespace App\Http\Resources\Social_Media\Group;

use App\Models\Image;
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
        $image=Image::where('category','group')->where('category_id',$this->id)->first();
        if($image)
        {
        return [
            'group_id'=>$this->id,
            'title'=>$this->title,
            'about'=>$this->about,
            'profile_image'=> asset('public/images/group/'.$image->image),
        ];
        }
        return [
            'group_id'=>$this->id,
            'title'=>$this->title,
            'about'=>$this->about,
            'profile_image'=> asset('public/images/user/profile/profile_user.jpg'),
        ];
    }

}
