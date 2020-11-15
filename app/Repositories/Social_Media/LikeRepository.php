<?php

namespace App\Repositories\Social_Media;

use App\Interfaces\Social_Media\LikeInterface;
use App\Models\Social_Media\Like;


class LikeRepository implements LikeInterface
{

    protected $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    public function Get_All_Datas()
    {
        return $this->like->all();
    }

    public function Get_All_Datas_Like($id,$category)
    {
        return $this->like->with('user')->where('category',$category)->where('category_id',$id)->get();
    }

}
