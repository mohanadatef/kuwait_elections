<?php

namespace App\Http\Resources\Social_Media;

use App\Http\Resources\ACL\UserResource;
use Carbon\Carbon;
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
            'created_at'=>Carbon::parse($this->created_at)->format('d/m/Y h:m'),
            'user'=> new UserResource($this->resource->user),
        ];
    }

}
