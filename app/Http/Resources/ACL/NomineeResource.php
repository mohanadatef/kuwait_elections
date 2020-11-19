<?php

namespace App\Http\Resources\ACL;

use App\Http\Resources\Image\ProfileImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NomineeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->image->first()->image)
        {
        return [
            'nominee_id'=>$this->id,
            'username'=>$this->name,
            'email'=>$this->email,
            'name'=>$this->name ,
            'family'=>$this->family_name ,
            'circle'=>$this->circle_id,
            'area'=>$this->area_id,
            'mobile'=>$this->mobile,
            'role'=>$this->role[0]->id,
            'about'=>$this->about,
            'birth_day'=>$this->birth_day,
            'gender'=>$this->gender,
            'job'=>$this->job,
            'address'=>$this->address,
            'degree'=>$this->degree,
            'profile_image'=> asset('public/images/user/profile/'.$this->image->first()->image),
        ];
        }
        return [
            'nominee_id'=>$this->id,
            'username'=>$this->name,
            'email'=>$this->email,
            'name'=>$this->name ,
            'family'=>$this->family_name ,
            'circle'=>$this->circle_id,
            'area'=>$this->area_id,
            'mobile'=>$this->mobile,
            'role'=>$this->role[0]->id,
            'about'=>$this->about,
            'birth_day'=>$this->birth_day,
            'gender'=>$this->gender,
            'job'=>$this->job,
            'address'=>$this->address,
            'degree'=>$this->degree,
            'profile_image'=> asset('public/images/user/profile/profile_user.jpg'),
        ];
    }
}
