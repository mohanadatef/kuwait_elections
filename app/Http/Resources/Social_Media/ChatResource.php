<?php

namespace App\Http\Resources\Social_Media;

use App\Http\Resources\ACL\UserResource;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image=Image::where('category','message')->where('category_id',$this->message_id)->first();
        if($image)
        {
            return [
                'message_id'=>$this->id,
                'your_message'=>$this->details,
                'post_image'=> asset('public/images/message/'.$this->message_id.'/'.$image->image),
                'user'=> new  UserResource($this->resource->user),
            ];
        }
        return [
            'message_id'=>$this->id,
            'your_message'=>$this->details,
            'post_image'=> '',
            'user'=> new  UserResource($this->resource->user),

        ];
    }

}
