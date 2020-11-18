<?php

namespace App\Http\Resources\Web\ACL;

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
            'log_id'=>$this->id,
            'username'=>$this->user->name,
            'action'=>$this->action,
            'description'=>$this->description,
            'time'=>$this->created_at,
        ];
    }
}
