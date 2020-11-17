<?php

namespace App\Http\Resources\Web\Social_Media;

use App\Http\Resources\Web\ACL\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
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
            'like_id'=>$this->id,
            'created_at'=>$this->created_at,
            'user'=> [new UserResource($this->resource->user)],
        ];
    }

}
