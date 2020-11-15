<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class About_Us extends Model
{
    protected $fillable = [
        'description','image','title'
    ];
    protected $table = 'about_us';
    public $timestamps = true;

}