<?php

namespace App\Traits;

use App\Models\ACL\Role_user;
use App\Models\Core_Data\Area;
use App\Models\Core_Data\Circle;
use App\Repositories\ACL\ForgotPasswordRepository;
use App\Repositories\ACL\FriendRepository;
use App\Repositories\ACL\LogRepository;
use App\Repositories\ACL\PermissionRepository;
use App\Repositories\ACL\RoleRepository;
use App\Repositories\ACL\UserRepository;
use App\Repositories\Core_Data\AreaRepository;
use App\Repositories\Core_Data\CircleRepository;
use App\Repositories\Election\VoteNomineeRepository;
use App\Repositories\Election\VoteRepository;
use App\User;
use \Illuminate\Database\Eloquent\Collection;


trait CoreDataa
{
    private $circleRepository;
    private $logRepository;
    private $userRepository;
    private $roleRepository;
    private $areaRepository;
    private $permissionRepository;
    private $friendRepository;
    private $forgotpasswordRepository;
    private $voteRepository;
    private $votenomineeRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository, LogRepository $LogRepository,
                                CircleRepository $circleRepository, AreaRepository $areaRepository,
                                PermissionRepository $permissionRepository,FriendRepository $friendRepository,
                                ForgotPasswordRepository $forgotpasswordRepository,VoteRepository $voteRepository,
                                VoteNomineeRepository $votenomineeRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->circleRepository = $circleRepository;
        $this->logRepository = $LogRepository;
        $this->areaRepository = $areaRepository;
        $this->permissionRepository = $permissionRepository;
        $this->friendRepository = $friendRepository;
        $this->forgotpasswordRepository = $forgotpasswordRepository;
        $this->voteRepository = $voteRepository;
        $this->votenomineeRepository = $votenomineeRepository;
    }
}
