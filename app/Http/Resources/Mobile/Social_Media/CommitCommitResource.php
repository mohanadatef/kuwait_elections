<?php

namespace App\Http\Resources\Mobile\Social_Media;

use App\Http\Resources\Mobile\ACL\UserResource;
use App\Http\Resources\Mobile\Image\CommitImageResource;
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
        if($this->image != null ) {
        return [
            'commit_commit_id'=>$this->id,
            'created_at'=>$this->created_at,
            'details'=>$this->details,
            'user'=> [new UserResource($this->resource->user)],
            'like_count'=> count($this->like),
            'like'=> [ LikeResource::collection($this->resource->like)],
            'commit_image'=> asset('public/images/commit/'.$this->image->first()->image),
        ];
    }
        return [
            'commit_commit_id'=>$this->id,
            'created_at'=>$this->created_at,
            'details'=>$this->details,
            'user'=> [new UserResource($this->resource->user)],
            'like_count'=> count($this->like),
            'like'=> [ LikeResource::collection($this->resource->like)],
        ];
    }

}
