<?php

namespace App\Http\Resources\ACL;

use App\Http\Resources\Image\ProfileImageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FriendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if (Auth::user()->id == $this->user_send_id) {
            return [
                'request_friend' => $this->id,
                'friend' => new UserResource($this->resource->user_receive),
            ];
        } elseif (Auth::user()->id == $this->user_send_id) {
            return [
                'request_friend' => $this->id,
                'friend' => new UserResource($this->resource->user_send),
            ];
        }

    }
}
