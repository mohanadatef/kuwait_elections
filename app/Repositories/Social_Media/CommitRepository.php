<?php

namespace App\Repositories\Social_Media;

use App\Http\Requests\Admin\Social_Media\Commit\StatusEditRequest;
use App\Interfaces\Social_Media\CommitInterface;
use App\Models\Social_Media\Commit;
use App\Models\Social_Media\Like;
use Illuminate\Http\Request;


class CommitRepository implements CommitInterface
{

    protected $commit;
    protected $like;

    public function __construct(Commit $commit,Like $like)
    {
        $this->commit = $commit;
        $this->like = $like;
    }

    public function Get_All_Datas()
    {
        return $this->commit->with(['like' => function ($query) {
            $query->where('category', 'commit')->orderby('created_at','DESC');
        }],'user')->get();
    }

    public function Get_All_Datas_Post($id)
    {

        return $this->commit->with(['like' => function ($query) {
            $query->where('category', 'commit');
        }],'user')->where('post_id',$id)->orderby('created_at','DESC')->get();
    }

    public function Get_One_Data($id)
    {
        return $this->commit->find($id);
    }

    public function Update_Status_One_Data($id)
    {
        $commit = $this->Get_One_Data($id);
        if ($commit->status == 1) {
            $commit->status = '0';
        } elseif ($commit->status == 0) {
            $commit->status = '1';
        }
        $commit->update();
    }

    public function Get_Many_Data(Request $request)
    {
      return  $this->commit->wherein('id',$request->change_status)->get();
    }

    public function Update_Status_Datas(StatusEditRequest $request)
    {
        $commits = $this->Get_Many_Data($request);
        foreach($commits as $commit)
        {
            if ($commit->status == 1) {
                $commit->status = '0';
            } elseif ($commit->status == 0) {
                $commit->status = '1';
            }
            $commit->update();
        }
    }


}
