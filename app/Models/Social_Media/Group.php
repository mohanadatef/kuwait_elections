<?php

namespace App\Models\Social_Media;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'title','about'
    ];
    public function image()
    {
        return $this->belongsTo('App\Models\Image','category_id');
    }
    public function group_user()
    {
        return $this->hasMany('App\Models\Social_Media\Group');
    }
    public function post()
    {
        return $this->hasMany('App\Models\Social_Media\Post');
    }
    protected $table = 'groups';
    public $timestamps = true;

}