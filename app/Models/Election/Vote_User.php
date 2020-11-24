<?php

namespace App\Models\Election;

use Illuminate\Database\Eloquent\Model;

class Vote_User extends Model
{
    protected $fillable = [
        'vote_id','nominee_id','user_id'
    ];
    public function nominee()
    {
        return $this->belongsTo('App\User','nominee_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function vote()
    {
        return $this->belongsTo('App\Models\Election\Vote','vote_id');
    }
    protected $table = 'vote_users';
    public $timestamps = true;

}