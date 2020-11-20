<?php

namespace App\Models\Election;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = [
        'user_id','status','nominee_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function nominee()
    {
        return $this->belongsTo('App\User','nominee_id');
    }
    protected $table = 'elections';
    public $timestamps = true;

}