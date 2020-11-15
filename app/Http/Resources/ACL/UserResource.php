<?php

namespace App\Http\Resources\ACL;

use App\Http\Resources\Image\ProfileImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'user_id'=>$this->id,
            'username'=>$this->username,
            'email'=>$this->email,
            'name'=>$this->name,
            'family'=>$this->family,
            'circle'=>$this->circle->title,
            'area'=>$this->area->title,
            'mobile'=>$this->mobile,
            'role'=>$this->role[0]->id,
            'birth_day'=>$this->birth_day,
            'gender'=>$this->gender,
            'job'=>$this->job,
            'address'=>$this->address,
            'token'=>$this->remember_token,
            'profile_image'=> asset('public/images/user/profile/'.$this->image->first()->image),
        ];
    }
}
