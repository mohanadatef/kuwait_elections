<?php

namespace App\Http\Resources\Setting;

use App\Http\Resources\ACL\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'notification_id'=>$this->id,
            'details'=>$this->details,
            'user_send'=>new UserResource($this->user_send),
        ];
    }
}
