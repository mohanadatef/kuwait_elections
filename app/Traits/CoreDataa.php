<?php

namespace App\Traits;

use App\Models\ACL\Role_user;
use App\Models\Core_Data\Area;
use App\Models\Core_Data\Circle;
use App\Repositories\ACL\LogRepository;
use App\Repositories\Core_Data\CircleRepository;
use App\User;
use \Illuminate\Database\Eloquent\Collection;


trait CoreDataa
{

    private $circleRepository;
    private $logRepository;

    public function __construct(CircleRepository $circleRepository,LogRepository $LogRepository)
    {

        $this->circleRepository = $circleRepository;
        $this->logRepository = $LogRepository;
    }



}
