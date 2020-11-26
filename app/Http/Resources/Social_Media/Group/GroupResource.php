<?php

namespace App\Http\Resources\Social_Media\Group;

use App\Models\Image;
use App\Models\Social_Media\Group_User;
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
        $group_member=0;
        $image=Image::where('category','group')->where('category_id',$this->id)->first();
        if($request->status_auth==1)
        {
            $group_member=Group_User::where('group_id',$this->id)->where('user_id',$request->user_id)->count();
        }
        if($image)
        {
        return [
            'group_id'=>$this->id,
            'status_join'=>$group_member,
            'title'=>$this->title,
            'about'=>$this->about,
            'profile_image'=> asset('public/images/group/'.$image->image),
        ];
        }
        return [
            'group_id'=>$this->id,
            'status_join'=>$group_member,
            'title'=>$this->title,
            'about'=>$this->about,
            'profile_image'=> asset('public/images/user/profile/profile_user.jpg'),
        ];
    }

}
