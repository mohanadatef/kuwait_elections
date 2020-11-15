<?php

namespace App\Http\Resources\Social_Media;

use App\Http\Resources\ACL\UserResource;
use App\Http\Resources\Image\CommitImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommitCommitResource extends JsonResource
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
            'created_at'=>$this->created_at,
            'details'=>$this->details,
            'user'=> [new UserResource($this->resource->user)],
            'like_count'=> count($this->like),
            'like'=> [ LikeResource::collection($this->resource->like)],
            'commit_image'=> [new CommitImageResource($this->image)],
        ];
    }

}
