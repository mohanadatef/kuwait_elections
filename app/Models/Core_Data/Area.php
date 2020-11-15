<?php

namespace App\Models\Core_Data;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'title','status','order'
    ];
    public function user()
    {
        return $this->hasMany('App\User');
    }
    protected $table = 'areas';
    public $timestamps = true;

}