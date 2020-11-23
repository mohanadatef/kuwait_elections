<?php

namespace App\Repositories\Election;

use App\Http\Requests\Admin\Election\Vote\CreateRequest;
use App\Http\Requests\Admin\Election\Vote\EditRequest;
use App\Http\Requests\Admin\Election\Vote\StatusEditRequest;
use App\Interfaces\Election\VoteInterface;
use App\Models\Election\Vote;
use App\Models\Election\Vote_Nominee;
use Illuminate\Http\Request;


class VoteRepository implements VoteInterface
{

    protected $vote;
    protected $vote_nominee;

    public function __construct(Vote $vote,Vote_Nominee $vote_nominee)
    {
        $this->vote = $vote;
        $this->vote_nominee = $vote_nominee;
    }

    public function Get_All_Datas()
    {
        return $this->vote->all();
    }

    public function Create_Data(CreateRequest $request)
    {
        $this->vote->status = 1;
        $this->vote->title=$request->title;
        $this->vote->circle_id=$request->circle_id;
        $this->vote->save();
        foreach ($request->nominee_id as $nominee_id)
        {
        $this->vote_nominee->vote_id=$this->vote->id;
        $this->vote_nominee->nominee_id=$nominee_id->id;
        $this->vote_nominee->nominee_count=0;
        $this->vote_nominee->save();
        }
    }

    public function Get_One_Data($id)
    {
        return $this->vote->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
        $vote = $this->Get_One_Data($id);
        $vote->update($request->all());
    }

    public function Update_Status_One_Data($id)
    {
        $vote = $this->Get_One_Data($id);
        if ($vote->status == 1) {
            $vote->status = '0';
        } elseif ($vote->status == 0) {
            $vote->status = '1';
        }
        $vote->update();
    }

    public function Get_Many_Data(Request $request)
    {
        return $this->vote->wherein('id', $request->change_status)->get();
    }

    public function Update_Status_Datas(StatusEditRequest $request)
    {
        $votes = $this->Get_Many_Data($request);
        foreach ($votes as $vote) {
            if ($vote->status == 1) {
                $vote->status = '0';
            } elseif ($vote->status == 0) {
                $vote->status = '1';
            }
            $vote->update();
        }
    }
}
