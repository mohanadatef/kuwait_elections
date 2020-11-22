<?php

namespace App\Models\Social_Media;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'details','status','user_id','post_id','group_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function like()
    {
        return $this->hasMany('App\Models\Social_Media\Like','category_id');
    }

    public function commit_post()
    {
        return $this->hasMany('App\Models\Social_Media\Commit');
    }
    public function image()
    {
        return $this->hasMany('App\Models\Image','category_id');
    }
    public function group()
    {
        return $this->belongsTo('App\Models\Social_Media\Group','group_id');
    }
    protected $table = 'posts';
    public $timestamps = true;

}