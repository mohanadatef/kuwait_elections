<?php

namespace App\Http\Resources\Social_Media;

use App\Http\Resources\ACL\UserResource;
use App\Models\Image;
use App\Models\Social_Media\Commit;
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
        $commit=Commit::where('commit_id',0)->where('post_id',$this->id)->where('status',1)->get();
        $image=Image::where('category','post')->where('category_id',$this->id)->first();
        if($image)
        {
            return [
                'post_id'=>$this->id,
                'details'=>$this->details,
                'post_image'=> asset('public/images/post/'.$image->image),
                'created_at'=>Carbon::parse($this->created_at)->format('d/m/Y h:m'),
                'user'=> new UserResource($this->resource->user),
                'like_count'=> count($this->like),
                'like'=>  LikeResource::collection($this->resource->like),
                'commit_count'=> count($this->commit_post),
                'commit'=>  CommitResource::collection($commit),
            ];
        }
        return [
            'post_id'=>$this->id,
            'details'=>$this->details,
            'post_image'=> '',
            'created_at'=>Carbon::parse($this->created_at)->format('d/m/Y h:m'),
            'user'=> new UserResource($this->resource->user),
            'like_count'=> count($this->like),
            'like'=>  LikeResource::collection($this->resource->like),
            'commit_count'=> count($this->commit_post),
            'commit'=> CommitResource::collection($commit),

        ];
    }

}
