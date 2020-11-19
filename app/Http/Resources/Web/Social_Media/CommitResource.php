<?php

namespace App\Http\Resources\Web\Social_Media;

use App\Http\Resources\Web\ACL\UserResource;
use App\Http\Resources\Web\Image\CommitImageResource;
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
        if($this->image != null ) {
            return [
                'commit_id' => $this->id,
                'created_at'=>Carbon::parse($this->created_at)->format('d/m/Y h:m'),
                'details' => $this->details,
                'user' => [new UserResource($this->resource->user)],
                'like_count' => count($this->like),
                'like' => [LikeResource::collection($this->resource->like)],
                'like_commit' => count($this->commit_commit),
                'commit_commit' => [CommitCommitResource::collection($this->resource->commit_commit)],
                'commit_image' => asset('public/images/commit/' . $this->image->first()->image),
            ];
        }
        return [
            'commit_id' => $this->id,
            'created_at'=>Carbon::parse($this->created_at)->format('d/m/Y h:m'),
            'details' => $this->details,
            'user' => [new UserResource($this->resource->user)],
            'like_count' => count($this->like),
            'like' => [LikeResource::collection($this->resource->like)],
            'like_commit' => count($this->commit_commit),
            'commit_commit' => [CommitCommitResource::collection($this->resource->commit_commit)],
        ];
    }

}
