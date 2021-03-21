<?php

namespace App\Traits;

use App\Models\ACL\Role_user;
use App\Models\Core_Data\Area;
use App\Models\Core_Data\Circle;
use App\User;
use \Illuminate\Database\Eloquent\Collection;


trait CoreData
{
    private $circle;
    private $user;
    private $role_user;
    private $area;

    public function __construct(User $user, Role_user $role_user, Area $area
                                ,Circle $circle)
    {
        $this->user = $user;
        $this->role_user = $role_user;
        $this->area = $area;
        $this->circle = $circle;
    }

    public function change_status($datas)
    {
        if ($datas instanceof Collection) {
            foreach ($datas as $data) {
                if ($data->status == 1) {
                    $data->status = '0';
                } elseif ($data->status == 0) {
                    $data->status = '1';
                }
                $data->update();
            }
        } else {
            if ($datas->status == 1) {
                $datas->status = '0';
            } elseif ($datas->status == 0) {
                $datas->status = '1';
            }
            $datas->update();
        }
    }

}
