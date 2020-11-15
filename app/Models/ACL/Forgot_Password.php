<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\Model;

class Forgot_Password extends Model
{
    protected $fillable = [
        'user_id','code','status'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    protected $table = 'forgot_passwords';
    public $timestamps = true;

}