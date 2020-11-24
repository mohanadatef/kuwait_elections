<?php

namespace App\Repositories\Election;

use App\Http\Requests\Admin\Election\Vote_Nominee\CreateRequest;
use App\Interfaces\Election\VoteNomineeInterface;
use App\Models\Election\Vote;
use App\Models\Election\Vote_Nominee;
use Illuminate\Support\Facades\DB;


class VoteNomineeRepository implements VoteNomineeInterface
{

    protected $vote_nominee;
    protected $vote;

    public function __construct(Vote_Nominee $vote_nominee,Vote $vote)
    {
        $this->vote_nominee = $vote_nominee;
        $this->vote = $vote;
    }

    public function Create_Data(CreateRequest $request,$id)
    {
        $vote=$this->vote->find($id);
        foreach ($request->nominee_id as $nominee)
        {
            $vote_nominee= $this->vote_nominee->where('vote_id',$vote->id)->where('nominee_id',$nominee)->first();
            if(!$vote_nominee)
            {
                $this->vote_nominee->nominee_id = $nominee;
                $this->vote_nominee->vote_id = $vote->id;
                $this->vote_nominee->nominee_count = 0;
                $this->vote_nominee->save();
            }
        }
    }

    public function Get_List_Nominee($id)
    {
        return DB::table('users')
            ->join('vote_nominees', 'vote_nominees.nominee_id', '=', 'users.id')
            ->select('users.id')
            ->pluck('users.id','users.id');
    }

}
