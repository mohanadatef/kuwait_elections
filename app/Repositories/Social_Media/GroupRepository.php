<?php

namespace App\Repositories\Social_Media;

use App\Http\Requests\Admin\Social_Media\Group\CreateRequest;
use App\Http\Requests\Admin\Social_Media\Group\EditRequest;
use App\Interfaces\Social_Media\GroupInterface;
use App\Models\Image;
use App\Models\Social_Media\Group;


class GroupRepository implements GroupInterface
{

    protected $group;
    protected $role_group;

    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    public function Get_All_Datas()
    {
        return $this->group->all();
    }

    public function Create_Data(CreateRequest $request)
    {
        $this->group->about=$request->about;
        $this->group->title=$request->title;
        $this->group->save();
        $profile_image = new Image();
        $profile_image->category_id = $this->group->id;
        $profile_image->category = 'group';
        $profile_image->status = 1;
        $imageName = $request->image->getClientOriginalname() . '-' . time() . '.' . Request()->image->getClientOriginalExtension();
        Request()->image->move(public_path('images/group'), $imageName);
        $profile_image->image = $imageName;
        $profile_image->save();
    }

    public function Get_One_Data($id)
    {
        return $this->group->find($id);
    }

    public function Update_Data(EditRequest $request, $id)
    {
        $group = $this->Get_One_Data($id);
        $group->update($request->all());
        if ($request->image) {
            $profile_image = new Image();
            $profile_image->category_id = $group->id;
            $profile_image->category = 'group';
            $profile_image->status = 1;
            $imageName = $request->image->getClientOriginalname() . '-' . time() . '.' . Request()->image->getClientOriginalExtension();
            Request()->image->move(public_path('images/group'), $imageName);
            $profile_image->image = $imageName;
            $profile_image->save();
        }
    }
}
