<?php

namespace App\Http\Resources\ACL;

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
        if($this->profile_image)
        {
            return [
                'user_id'=>$this->id,
                'username'=>$this->first_name .' '.$this->second_name,
                'email'=>$this->email,
                'family_name'=>$this->family_name,
                'name'=>$this->name,
                'first_name'=>$this->first_name,
                'second_name'=>$this->second_name,
                'third_name'=>$this->third_name,
                'forth_name'=>$this->forth_name,
                'internal_reference'=>$this->internal_reference,
                'civil_reference'=>$this->civil_reference,
                'registration_status'=>$this->registration_status,
                'registration_number'=>$this->registration_number,
                'registration_data'=>$this->registration_data,
                'token'=>$this->remember_token,
                'profile_image'=> asset('public/images/user/profile/'.$this->profile_image->image),
                'role'=>$this->role[0]->id,
                'birth_day'=>$this->birth_day,
                'gender'=>$this->gender,
                'job'=>$this->job,
                'address'=>$this->address,
                'mobile'=>$this->mobile,
                'about'=>$this->about,
                'degree'=>$this->degree,
                'circle'=>$this->circle_id,
                'area'=>$this->area_id,
            ];
        }
        return [
            'user_id'=>$this->id,
            'username'=>$this->first_name .' '.$this->second_name,
            'email'=>$this->email,
            'family_name'=>$this->family_name,
            'name'=>$this->name,
            'first_name'=>$this->first_name,
            'second_name'=>$this->second_name,
            'third_name'=>$this->third_name,
            'forth_name'=>$this->forth_name,
            'internal_reference'=>$this->internal_reference,
            'civil_reference'=>$this->civil_reference,
            'registration_status'=>$this->registration_status,
            'registration_number'=>$this->registration_number,
            'registration_data'=>$this->registration_data,
            'token'=>$this->remember_token,
            'profile_image'=> asset('public/images/user/profile/profile_user.jpg'),
            'role'=>$this->role[0]->id,
            'birth_day'=>$this->birth_day,
            'gender'=>$this->gender,
            'job'=>$this->job,
            'address'=>$this->address,
            'mobile'=>$this->mobile,
            'about'=>$this->about,
            'degree'=>$this->degree,
            'circle'=>$this->circle_id,
            'area'=>$this->area_id,
        ];
    }
}
