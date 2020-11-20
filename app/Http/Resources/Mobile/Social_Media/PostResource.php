<?php

namespace App\Http\Resources\Mobile\Social_Media;

use App\Http\Resources\Mobile\ACL\UserResource;
use App\Http\Resources\Mobile\Image\CommitImageResource;
use App\Http\Resources\Mobile\Image\PostImageResource;
use Carbon\Carbon;
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
        if($this->resource->image)
        {
            return [
                'post_id'=>$this->id,
                'details'=>$this->details,
                'post_image'=> asset('public/images/post/'.$this->image->first()->image),
                'created_at'=>Carbon::parse($this->created_at)->format('d/m/Y h:m'),
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
            'created_at'=>Carbon::parse($this->created_at)->format('d/m/Y h:m'),
            'user'=> [new UserResource($this->resource->user)],
            'like_count'=> count($this->like),
            'like'=> [ LikeResource::collection($this->resource->like)],
            'commit_count'=> count($this->commit_post),
            'commit'=> [ CommitResource::collection($this->resource->commit_post)],

        ];
    }

}
