<?php

namespace App\Http\Resources\Election;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class VoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'vote_id' => $this->id,
            'title' => $this->title,
            'count_nominee'=>count($this->vote_nominee),
            'vote_nominee' => VoteNomineeResource::collection($this->vote_nominee),
        ];
    }
}
