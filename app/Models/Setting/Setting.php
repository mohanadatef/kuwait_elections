<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{
    protected $fillable = [
        'image','facebook','youtube','twitter','logo','title'
    ];
    protected $table = 'settings';
    public $timestamps = true;

}