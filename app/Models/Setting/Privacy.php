<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    protected $fillable = [
        'description'
    ];
    protected $table = 'privacies';
    public $timestamps = true;

}