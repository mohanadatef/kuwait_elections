<?php

namespace App\Http\Resources\Social_Media;

use App\Http\Resources\ACL\UserResource;
use App\Models\Image;
use Carbon\Carbon;
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
        $image=Image::where('category','commit')->where('category_id',$this->id)->first();
        if($image ) {
        return [
            'commit_commit_id'=>$this->id,
            'created_at'=>Carbon::parse($this->created_at)->format('d/m/Y h:m'),
            'details'=>$this->details,
            'commit_image'=> asset('public/images/commit/'.$image->image),
            'user'=> new UserResource($this->resource->user),
            'like_count'=> count($this->like),
            'like'=>  LikeResource::collection($this->resource->like),
        ];
    }
        return [
            'commit_commit_id'=>$this->id,
            'created_at'=>Carbon::parse($this->created_at)->format('d/m/Y h:m'),
            'details'=>$this->details,
            'commit_image'=>'',
            'user'=> new UserResource($this->resource->user),
            'like_count'=> count($this->like),
            'like'=>  LikeResource::collection($this->resource->like),
        ];
    }

}
