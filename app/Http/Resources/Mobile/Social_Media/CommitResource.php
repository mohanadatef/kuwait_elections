<?php

namespace App\Http\Resources\Mobile\Social_Media;

use App\Http\Resources\Mobile\ACL\UserResource;
use App\Http\Resources\Mobile\Image\CommitImageResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CommitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->resource->image->first()->image ) {
            return [
                'commit_id' => $this->id,
                'created_at'=>Carbon::parse($this->created_at)->format('d/m/Y h:m'),
                'details' => $this->details,
                'commit_image' => asset('public/images/commit/' . $this->resource->image->first()->image),
                'user' => new UserResource($this->resource->user),
                'like_count' => count($this->like),
                'like' => LikeResource::collection($this->resource->like),
                'like_commit' => count($this->commit_commit),
                'commit_commit' => CommitCommitResource::collection($this->resource->commit_commit),
            ];
        }
        return [
            'commit_id' => $this->id,
            'created_at'=>Carbon::parse($this->created_at)->format('d/m/Y h:m'),
            'details' => $this->details,
            'commit_image' =>'',
            'user' => new UserResource($this->resource->user),
            'like_count' => count($this->like),
            'like' => LikeResource::collection($this->resource->like),
            'like_commit' => count($this->commit_commit),
            'commit_commit' => CommitCommitResource::collection($this->resource->commit_commit),
        ];
    }

}
