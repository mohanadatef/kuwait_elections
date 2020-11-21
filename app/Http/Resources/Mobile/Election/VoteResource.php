<?php

namespace App\Http\Resources\Mobile\Election;

use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
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
                'vote_id'=>$this->id,
                'title'=>$this->title,
            ];
    }
}
