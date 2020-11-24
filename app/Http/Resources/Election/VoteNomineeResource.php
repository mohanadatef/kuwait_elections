<?php

namespace App\Http\Resources\Election;

use App\Models\Election\Vote_User;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
        $vote_user_nominee=Vote_User::where('vote_id',$this->vote_id)->where('nominee_id',$this->nominee_id)->where('user_id',Auth::user()->id)->count();
        $vote_nominee = User::find($this->nominee_id);
        if($vote_user_nominee != 0)
        {
        return [
            'count_vote' => $this->nominee_count,
            'selected' => 1,
            'nominee' => new NomineeResource($vote_nominee),
        ];
        }
        return [
            'count_vote' => $this->nominee_count,
            'selected' => 0,
            'nominee' => new NomineeResource($vote_nominee),
        ];
    }
}
