<?php

namespace App\Models\Election;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'title','circle_id','status'
    ];
    public function circle()
    {
        return $this->belongsTo('App\Models\Core_Data\Circle','circle_id');
    }
    public function vote_nominee()
    {
        return $this->hasMany('App\Models\Election\Vote_Nominee');
    }
    protected $table = 'votes';
    public $timestamps = true;

}