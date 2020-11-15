<?php

namespace App\Http\Resources\ACL;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
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
            'username'=>$this->user->username,
            'action'=>$this->action,
            'description'=>$this->description,
            'time'=>$this->created_at,
        ];
    }
}
