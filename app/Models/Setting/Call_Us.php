<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Call_Us extends Model
{
    protected $fillable = [
        'name','message','mobile','email','status'
    ];
    protected $table = 'call_us';
    public $timestamps = true;

}