<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'action','user_id','description'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    protected $table = 'logs';
    public $timestamps = true;

}