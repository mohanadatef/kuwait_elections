<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_send_id ','user_receive_id ','details','status'
    ];
    public function user_send()
    {
        return $this->belongsTo('App\User', 'user_send_id');
    }

    public function user_receive()
    {
        return $this->belongsTo('App\User', 'user_receive_id');
    }

    protected $table = 'notifications';
    public $timestamps = true;

}