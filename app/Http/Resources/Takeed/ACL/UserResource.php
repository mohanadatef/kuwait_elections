<?php

namespace App\Http\Resources\Takeed\ACL;

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
                'username'=>$this->first_name .' '.$this->second_name,
                'email'=>$this->email,
                'civil_reference'=>$this->civil_reference,
                'token'=>$this->remember_token,
                'role'=>$this->role[0]->id,
                'mobile'=>$this->mobile,
                'circle'=>$this->circle_id,
            ];
    }
}
