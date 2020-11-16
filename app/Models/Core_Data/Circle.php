<?php

namespace App\Models\Core_Data;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    protected $fillable = [
        'title','status','order'
    ];
    public function user()
    {
        return $this->hasMany('App\User');
    }
    public function takeed()
    {
        return $this->hasMany('App\Models\ACL\Takeed','circle');
    }
    protected $table = 'circles';
    public $timestamps = true;

}