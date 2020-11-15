<?php

namespace App\Http\Controllers\Api\Social_Media;


use App\Http\Resources\Social_Media\LikeResource;
use App\Http\Resources\Social_Media\PostResource;
use App\Models\Image;
use App\Models\Social_Media\Commit;
use App\Models\Social_Media\Like;
use App\Models\Social_Media\Post;
use App\Repositories\ACL\LogRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class CommitController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;                                
    }

    public function store(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'details' => 'required|string|max:255',
            'post'=>'required|exists:posts,id',
            'image_commit'=>'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 422);
        }
        $commit = new Commit();
        $commit->details = $request->details;
        $commit->status = 1;
        $commit->post_id = $request->post;
        $commit->user_id = $request->id;
        if($request->commit_id)
        {
            $commit->commit_id = $request->commit_id;
        }
        $commit->save();
        if($request->image_commit)
        {
            $imageName = $request->image_commit->getClientOriginalname().'-'.time() .'.'.Request()->image_commit->getClientOriginalExtension();
            Request()->image_commit->move(public_path('images/commit'), $imageName);
            $commit_image_save = new Image();
            $commit_image_save->category_id = $request->id;
            $commit_image_save->category = 'commit';
            $commit_image_save->status = 1;
            $commit_image_save->image = $imageName;
            $commit_image_save->save();
        }
        $post = Post::with(['commit_post' => function ($query) {
            $query->where('status', 1);
        }],['like' => function ($query) {
            $query->where('category', 'post')->orderby('created_at','asc');
        }])->where('id', $request->post)->where('status', 1)->first();
        if ($post) {
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'تسجيل تعليق على منشور', 'تسجيل تعليق جديد فى منشور عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
            return response([
                'message' => 'تم تسجيل تعليق على منشور بنجاح',
                'data' => array(new PostResource($post))
            ], 201);
        }
        return response(['message' => 'خطا فى تسجيل تعليق على منشور'], 400);
    }

    public function update(Request $request)
    {
          $commit = Commit::find($request->id);
          if($commit) {
              $validate = \Validator::make($request->all(), [
                  'details' => 'required|string|max:255',
                  'post'=>'required|exists:posts,id',
                  'image_commit'=>'image|mimes:jpg,jpeg,png,gif|max:2048',
              ]);
              if ($validate->fails()) {
                  return response(['message' => $validate->errors()], 422);
              }
              $commit->commit = $request->commit;
              $commit->save();
              if($request->image_commit)
              {
                  $imageName = $request->image_commit->getClientOriginalname().'-'.time() .'.'.Request()->image_commit->getClientOriginalExtension();
                  Request()->image_commit->move(public_path('images/commit'), $imageName);
                  $commit_image_save = new Image();
                  $commit_image_save->category_id = $request->id;
                  $commit_image_save->category = 'commit';
                  $commit_image_save->status = 1;
                  $commit_image_save->image = $imageName;
                  $commit_image_save->save();

              }
              $post = Post::with(['commit_post' => function ($query) {
                  $query->where('status', 1);
              }],['like' => function ($query) {
                  $query->where('category', 'post');
              }])->where('id', $request->post)->where('status', 1)->first();
              if ($post) {
                  $this->logRepository->Create_Data('' . Auth::user()->id . '', 'تعديل تعليق على منشور', 'تعديل تعليق منشور عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
                  return response([
                      'message' => 'تم تعديل تعليق على منشور بنجاح',
                      'data' => array(new PostResource($post))
                  ], 201);
              }
          }
          return response(['message' => 'خطا فى تسجيل تعليق على منشور'], 400);
    }

    public function delete(Request $request)
    {
        $commit = Commit::find($request->id);
        if($commit)
        {
            $likes = Like::where('category', 'commit')->where('category_id', $commit->id)->get();
            if($likes)
            {
                foreach ($likes as $like)
                {
                    $like->delete();
                }
            }
            $commit_commits = Commit::where('commit_id',$commit->id)->get();
            foreach ($commit_commits as $commit_commit)
            {
                $likes = Like::where('category', 'commit')->where('category_id', $commit_commit->id)->get();
                if($likes)
                {
                    foreach ($likes as $like)
                    {
                        $like->delete();
                    }
                }
                $image_commit = Image::where('category','commit')->where('category_id',$commit_commit->id)->get();
                if($image_commit)
                {
                    foreach ($image_commit as $image_commits)
                    {
                        $image_commits->delete();
                    }
                }
                $commit_commit->delete();
            }
            $image_commit = Image::where('category','commit')->where('category_id',$commit->id)->get();
            if($image_commit)
            {
                foreach ($image_commit as $image_commits)
                {
                    $image_commits->delete();
                }
            }
            $commit->delete();
        $this->logRepository->Create_Data('' . Auth::user()->id . '', 'مسح تعليق على منشور', 'مسح تعليق عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id);
            return response([
                'message' => 'تم مسح تعليق على منشور بنجاح',
            ], 201);
        }
        return response(['message' => 'خطا فى مسح تعليق على منشور'], 400);
    }

    public function like(Request $request)
    {
        $like = Like::where('category', 'commit')->where('category_id', $request->id)->where('user_id',Auth::User()->id)->first();
        if($like == null)
        {
            $like = new Like();
            $like->commit_id=$request->id;
            $like->user_id=Auth::User()->id;
            $like->save();
            $data = Like::with('user')->where('category','commit')->where('category_id',$request->id)->get();
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'اعجاب', 'تسجيل اعجاب منشور للمستخدم عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id . " / منشور " . $request->id);
            return response(['message' => 'تم عمل اعجاب بنجاح','data'=>array(new LikeResource($data)),'count'=>count($data)], 200);
        }
        else
        {
            $like->delete();
            $data = Like::with('user')->where('category','commit')->where('commit_id',$request->id)->get();
            $this->logRepository->Create_Data(''.Auth::user()->id.'', 'مسح الاعجاب', 'مسح اعجاب منشور للمستخدم عن طريق Api' . Auth::user()->username . " / " . Auth::user()->id . " / منشور " . $request->id);
            return response(['message' => 'تم مسح اعجاب بنجاح','data'=>array(new LikeResource($data)),'count'=>count($data)], 200);
        }
    }
}
