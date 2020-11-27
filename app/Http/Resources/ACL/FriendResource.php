<?php

namespace App\Http\Resources\ACL;

use Illuminate\Http\Resources\Json\JsonResource;


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

        if ($request->user_id == $this->user_send_id) {

            return [
                'request_friend_id' => $this->id,
                'friend' => new UserResource($this->resource->user_receive),
            ];
        } elseif ($request->user_id == $this->user_receive_id) {

            return [
                'request_friend_id' => $this->id,
                'friend' => new UserResource($this->resource->user_send),
            ];
        }

    }
}
