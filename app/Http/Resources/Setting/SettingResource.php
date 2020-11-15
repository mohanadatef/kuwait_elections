<?php

namespace App\Http\Resources\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'facebook'=>$this->facebook,
            'youtube'=>$this->youtube,
            'twitter'=>$this->twitter,
            'title'=>$this->title,
            'logo'=>asset('public/images/setting/'.$this->logo),
            'image'=>asset('public/images/setting/'.$this->image),
        ];
    }
}
