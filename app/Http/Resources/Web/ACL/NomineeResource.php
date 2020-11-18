<?php

namespace App\Http\Resources\Web\ACL;

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
                'profile_image'=> asset('public/images/user/profile/'.$this->image->first()->image),
                'role'=>$this->role[0]->id,
                'birth_day'=>$this->birth_day,
                'gender'=>$this->gender,
                'job'=>$this->job,
                'address'=>$this->address,
                'mobile'=>$this->mobile,
                'about'=>$this->about,
                'degree'=>$this->degree,
                'circle'=>$this->circle->title,
                'area'=>$this->area->title,
            ];
        }
        return [
            'nominee_id'=>$this->id,
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
            'circle'=>$this->circle->title,
            'area'=>$this->area->title,
        ];
    }
}
