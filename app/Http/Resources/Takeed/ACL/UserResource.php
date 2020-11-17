<?php

namespace App\Http\Resources\Takeed\ACL;

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
            'circle_id'=>$this->circle->title,
            'role_id'=>$this->role[0]->id,
        ];
    }
}
