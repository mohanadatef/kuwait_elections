<?php

namespace App\Http\Resources\Election;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteNomineeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $vote_nominee = User::find($this->nominee_id);
        return [
            'count_vote' => $this->nominee_count,
            'nominee' => new NomineeResource($vote_nominee),
        ];
    }
}
