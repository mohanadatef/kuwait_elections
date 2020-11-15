<?php

namespace App\Models\Social_Media;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'user_id','category_id','category'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function commit()
    {
        return $this->belongsTo('App\Models\Social_Media\Commit','category_id');
    }
    public function post()
    {
        return $this->belongsTo('App\Models\Social_Media\Post','category_id');
    }
    protected $table = 'likes';
    public $timestamps = true;

}