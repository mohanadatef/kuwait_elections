<?php

namespace App\Models\Social_Media;

use Illuminate\Database\Eloquent\Model;

class Group_User extends Model
{
    protected $fillable = [
        'user_id','group_id'
    ];
    public function group()
    {
        return $this->belongsTo('App\Models\Social_Media\Group','group_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    protected $table = 'group_users';
    public $timestamps = true;

}