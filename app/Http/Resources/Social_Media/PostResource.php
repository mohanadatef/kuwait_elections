<?php

namespace App\Http\Resources\Social_Media;

use App\Http\Resources\ACL\UserResource;
use App\Http\Resources\Image\CommitImageResource;
use App\Http\Resources\Image\PostImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       if($this->image->first() )
       {
        return [
            'post_id'=>$this->id,
            'details'=>$this->details,
            'post_image'=> asset('public/images/post/'.$this->image->first()->image),
            'user'=> [new UserResource($this->resource->user)],
            'like_count'=> count($this->like),
            'like'=> [ LikeResource::collection($this->resource->like)],
            'commit_count'=> count($this->commit_post),
            'commit'=> [ CommitResource::collection($this->resource->commit_post)],
        ];
       }
        return [
            'post_id'=>$this->id,
            'details'=>$this->details,
            'post_image'=> '',
            'user'=> [new UserResource($this->resource->user)],
            'like_count'=> count($this->like),
            'like'=> [ LikeResource::collection($this->resource->like)],
            'commit_count'=> count($this->commit_post),
            'commit'=> [ CommitResource::collection($this->resource->commit_post)],
        ];
    }

}
