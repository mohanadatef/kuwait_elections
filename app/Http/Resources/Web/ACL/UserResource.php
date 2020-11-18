<?php

namespace App\Http\Resources\Web\ACL;

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
            'email'=>$this->email,
            'token'=>$this->remember_token,
            'profile_image'=> asset('public/images/user/profile/'.$this->image->first()->image),
            'role'=>$this->role[0]->id,
            'birth_day'=>$this->birth_day,
            'gender'=>$this->gender,
            'job'=>$this->job,
            'address'=>$this->address,
        ];
    }
}
