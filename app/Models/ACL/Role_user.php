<?php

namespace App\Models\ACL;
use Illuminate\Database\Eloquent\Model;


class Role_user  extends Model
{

    protected $fillable = [
        'user_id','role_id'
    ];
    protected $table = 'role_user';
    public $timestamps = true;


}