<?php

namespace App\Repositories\ACL;

use App\Interfaces\ACL\FriendInterface;
use App\Models\ACL\Friend;


class FriendRepository implements FriendInterface
{

    protected $friend;

    public function __construct(Friend $friend)
    {
        $this->friend = $friend;
    }

    public function Get_All_Request_Data()
    {
        return $this->friend->where('wait', 0)->get();
    }

    public function Get_All_Friend_Data()
    {
        return $this->friend->where('wait', 1)->get();
    }
}
