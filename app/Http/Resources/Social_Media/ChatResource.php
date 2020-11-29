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
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $image = Image::where('category', 'message-' . $this->message_id)->where('category_id', $this->id)->first();
        if ($image) {
            if($this->resource->user->id == $this->message->user_send_id)
            {
            return [
                'message_id' => $this->id,
                'your_message' => $this->details,
                'post_image' => asset('public/images/message/' . $this->message_id . '/' . $image->image),
                'user_send' => new  UserResource($this->resource->user),
                'user_receive' => new  UserResource($this->message->user_receive),
            ];
            }
            else{
                return [
                    'message_id' => $this->id,
                    'your_message' => $this->details,
                    'post_image' => asset('public/images/message/' . $this->message_id . '/' . $image->image),
                    'user_send' => new  UserResource($this->resource->user),
                    'user_receive' => new  UserResource($this->message->user_send),
                ];
            }
        }
        if($this->resource->user->id == $this->message->user_send_id)
        {
        return [
            'message_id' => $this->id,
            'your_message' => $this->details,
            'post_image' => '',
            'user_send' => new  UserResource($this->resource->user),
            'user_receive' => new  UserResource($this->message->user_receive),
        ];
        }
        else{
            return [
                'message_id' => $this->id,
                'your_message' => $this->details,
                'post_image' => '',
                'user_send' => new  UserResource($this->resource->user),
                'user_receive' => new  UserResource($this->message->user_send),
            ];
        }
    }
}
