<?php

namespace App\Traits;

use App\Models\ACL\Role_user;
use App\Models\Core_Data\Area;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\RoleRepository;
use App\Repositories\ACL\UserRepository;
use App\Repositories\Core_Data\AreaRepository;
use App\Repositories\Core_Data\CircleRepository;
use App\User;
use \Illuminate\Database\Eloquent\Collection;


trait CoreData
{
    protected $user;
    protected $role_user;
    protected $area;
    private $userRepository;
    private $circleRepository;
    private $roleRepository;
    private $logRepository;
    private $areaRepository;

    public function __construct(User $user, Role_user $role_user, Area $area, UserRepository $userRepository,
                                RoleRepository $roleRepository, LogRepository $LogRepository,
                                CircleRepository $circleRepository, AreaRepository $areaRepository)
    {
        $this->user = $user;
        $this->role_user = $role_user;
        $this->area = $area;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->circleRepository = $circleRepository;
        $this->logRepository = $LogRepository;
        $this->areaRepository = $areaRepository;
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
