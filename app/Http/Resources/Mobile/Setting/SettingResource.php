<?php

namespace App\Http\Resources\Mobile\Setting;

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
            'facebook'=>$this->facebook,
            'youtube'=>$this->youtube,
            'twitter'=>$this->twitter,
            'title'=>$this->title,
            'status_election_show'=>$this->status_election_show,
            'logo'=>asset('public/images/setting/'.$this->logo),
            'image'=>asset('public/images/setting/'.$this->image),
        ];
    }
}
