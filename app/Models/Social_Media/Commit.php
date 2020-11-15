<?php

namespace App\Models\Social_Media;

use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    protected $fillable = [
        'user_id','post_id','details','status','commit_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function post()
    {
        return $this->belongsTo('App\Models\Social_Media\Post','post_id');
    }
    public function like()
    {
        return $this->hasMany('App\Models\Social_Media\Like','category_id');
    }
    public function commit_commit()
    {
        return $this->hasMany('App\Models\Social_Media\Commit','commit_id');
    }
    public function image()
    {
        return $this->belongsTo('App\Models\Image','category_id');
    }
    protected $table = 'commits';
    public $timestamps = true;

}