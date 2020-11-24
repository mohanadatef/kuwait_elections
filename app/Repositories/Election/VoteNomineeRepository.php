<?php

namespace App\Repositories\Election;

use App\Http\Requests\Admin\Election\Vote_Nominee\CreateRequest;
use App\Interfaces\Election\VoteNomineeInterface;
use App\Models\Election\Vote_Nominee;


class VoteNomineeRepository implements VoteNomineeInterface
{

    protected $vote_nominee;

    public function __construct(Vote_Nominee $vote_nominee)
    {
        $this->vote_nominee = $vote_nominee;
    }

    public function Create_Data(CreateRequest $request)
    {
        $data['status'] = 1;
        $this->vote_nominee->create(array_merge($data,$request));
    }

}
