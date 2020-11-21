<?php

namespace App\Models\Election;

use Illuminate\Database\Eloquent\Model;

class Vote_Nominee extends Model
{
    protected $fillable = [
        'vote_id','nominee_id','nominee_count'
    ];
    public function nominee()
    {
        return $this->hasMany('App\User','nominee_id');
    }
    public function vote()
    {
        return $this->belongsTo('App\Models\Election\Vote','vote_id');
    }
    protected $table = 'vote_nominees';
    public $timestamps = true;

}