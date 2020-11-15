<?php

namespace App\Repositories\Social_Media;

use App\Http\Requests\Admin\Social_Media\Post\StatusEditRequest;
use App\Interfaces\Social_Media\PostInterface;
use App\Models\Social_Media\Like;
use App\Models\Social_Media\Post;
use Illuminate\Http\Request;


class PostRepository implements PostInterface
{

    protected $post;
    protected $like;

    public function __construct(Post $post,Like $like)
    {
        $this->post = $post;
        $this->like = $like;
    }

    public function Get_All_Datas()
    {
        return $this->post->with(['like' => function ($query) {
            $query->where('category', 'post')->orderby('created_at','DESC');
        }],'commit_post')->get();
    }

    public function Get_One_Data($id)
    {
        return $this->post->find($id);
    }

    public function Update_Status_One_Data($id)
    {
        $post = $this->Get_One_Data($id);
        if ($post->status == 1) {
            $post->status = '0';
        } elseif ($post->status == 0) {
            $post->status = '1';
        }
        $post->update();
    }

    public function Get_Many_Data(Request $request)
    {
      return  $this->post->wherein('id',$request->change_status)->get();
    }

    public function Update_Status_Datas(StatusEditRequest $request)
    {
        $posts = $this->Get_Many_Data($request);
        foreach($posts as $post)
        {
            if ($post->status == 1) {
                $post->status = '0';
            } elseif ($post->status == 0) {
                $post->status = '1';
            }
            $post->update();
        }
    }


}
