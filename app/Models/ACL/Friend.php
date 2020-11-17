<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = [
        'user_send_id', 'status', 'user_receive_id'
    ];

    public function user_send()
    {
        return $this->belongsTo('App\User', 'user_send_id');
    }

    public function user_receive()
    {
        return $this->belongsTo('App\User', 'user_receive_id');
    }

    protected $table = 'friends';
    public $timestamps = true;

}