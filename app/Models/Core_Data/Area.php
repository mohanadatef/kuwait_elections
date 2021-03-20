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

    public function scopeStatus($query)
    {
        return $query->where('status',1);
    }

    protected $table = 'areas';
    public $timestamps = true;

}
