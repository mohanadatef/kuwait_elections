<?php

namespace App\Http\Resources\Election;

use App\Models\Election\Vote_User;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
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
        $vote_user_nominee=Vote_User::where('vote_id',$this->id)->where('user_id',Auth::user()->id)->count();
        if($vote_user_nominee)
        {
        return [
            'vote_id' => $this->id,
            'selected_vote' => 1,
            'title' => $this->title,
            'count_nominee'=>count($this->vote_nominee),
            'vote_nominee' => VoteNomineeResource::collection($this->vote_nominee),
        ];
        }
        return [
            'vote_id' => $this->id,
            'selected_vote' => 0,
            'title' => $this->title,
            'count_nominee'=>count($this->vote_nominee),
            'vote_nominee' => VoteNomineeResource::collection($this->vote_nominee),
        ];
    }
}
