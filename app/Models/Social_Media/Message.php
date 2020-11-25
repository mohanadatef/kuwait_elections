<?php

namespace App\Models\Social_Media;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_send_id',  'user_receive_id'
    ];

    public function user_send()
    {
        return $this->belongsTo('App\User', 'user_send_id');
    }

    public function user_receive()
    {
        return $this->belongsTo('App\User', 'user_receive_id');
    }
    public function chat()
    {
        return $this->hasMany('App\Models\Social_Media\Message_User');
    }
    protected $table = 'messages';
    public $timestamps = true;

}