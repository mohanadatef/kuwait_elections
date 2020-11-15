<?php

namespace App\Models\ACL;
use Zizaco\Entrust\EntrustPermission;

class Permission  extends EntrustPermission
{
    protected $fillable = [
        'name','display_name','description'
    ];
    public function role()
    {
        return $this->belongsToMany('App\Models\ACL\Role', 'permissions_role', 'role_id','permission_id')->paginate();
    }
    protected $table = 'permissions';
    public $timestamps = true;

}