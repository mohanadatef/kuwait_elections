<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'category_id','category','status','image'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','category_id');
    }
    public function post()
    {
        return $this->belongsTo('App\Models\Social_Media\Post','category_id');
    }
    public function commit()
    {
        return $this->belongsTo('App\Models\Social_Media\Commit','category_id');
    }
    public function group()
    {
        return $this->belongsTo('App\Models\Social_Media\Group','category_id');
    }
    public function chat()
    {
        return $this->belongsTo('App\Models\Social_Media\Message_User','category_id');
    }
    protected $table = 'images';
    public $timestamps = true;

}