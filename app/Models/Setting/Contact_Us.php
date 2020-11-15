<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Contact_Us extends Model
{
    protected $fillable = [
        'address','time_work','latitude','longitude','phone','email'
    ];
    protected $table = 'contact_us';
    public $timestamps = true;

}