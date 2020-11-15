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
        return [
            'key'=>$this->id,
            'username'=>$this->username,
            'email'=>$this->email,
            'name'=>$this->name ,
            'family'=>$this->family ,
            'circle'=>$this->circle->title,
            'area'=>$this->area->title,
            'mobile'=>$this->mobile,
            'role'=>$this->role[0]->display_name,
            'about'=>$this->about,
            'birth_day'=>$this->birth_day,
            'gender'=>$this->gender,
            'job'=>$this->job,
            'address'=>$this->address,
            'degree'=>$this->degree,
            'profile_image'=> asset('public/images/user/profile/'.$this->image->first()->image),
        ];
    }
}
