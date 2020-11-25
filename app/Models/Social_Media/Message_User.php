<?php

namespace App\Models\Social_Media;

use Illuminate\Database\Eloquent\Model;

class Message_User extends Model
{
    protected $fillable = [
        'details','user_id','message_id','status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function message()
    {
        return $this->belongsTo('App\Models\Social_Media\Message', 'message_id');
    }
    public function image()
    {
        return $this->belongsTo('App\Models\Image','category_id');
    }
    protected $table = 'message_users';
    public $timestamps = true;

}