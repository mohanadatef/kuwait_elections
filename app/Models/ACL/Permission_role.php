<?php

namespace App\Models\ACL;
use Illuminate\Database\Eloquent\Model;


class Permission_role  extends Model
{

    protected $fillable = [
        'permission_id','role_id'
    ];

    protected $table = 'permission_role';
    public $timestamps = true;

}