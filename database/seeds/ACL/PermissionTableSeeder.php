<?php
use Illuminate\Support\Facades\DB;
use App\Models\ACL\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $permissions=[
            //dashboard
            [
                'name'=>'dashboard-show',
                'display_name'=>'dashboard show',
                'description'=>'show dashboard',
            ],
            //acl
            [
                'name'=>'acl-list',
                'display_name'=>'acl list',
                'description'=>'list acl',
            ],
            //user
            [
                'name'=>'user-list',
                'display_name'=>'user list',
                'description'=>'list user',
            ],
            [
                'name'=>'user-index',
                'display_name'=>'index user',
                'description'=>'index data in user',
            ],
            [
                'name'=>'user-create',
                'display_name'=>'create user',
                'description'=>'create data in user',
            ],
            [
                'name'=>'user-edit',
                'display_name'=>'edit user',
                'description'=>'edit data in user',
            ],
            [
                'name'=>'user-password',
                'display_name'=>'password user',
                'description'=>'password data in user',
            ],
            [
                'name'=>'user-status',
                'display_name'=>'user status',
                'description'=>'user status',
            ],
            [
                'name'=>'user-many-status',
                'display_name'=>'user many status',
                'description'=>'user many status',
            ],
            //role
            [
                'name'=>'role-list',
                'display_name'=>'list role',
                'description'=>'list data in role',
            ],
            [
                'name'=>'role-index',
                'display_name'=>'index role',
                'description'=>'index data in role',
            ],
            [
                'name'=>'role-create',
                'display_name'=>'create role',
                'description'=>'create data in role',
            ],
            [
                'name'=>'role-edit',
                'display_name'=>'edit role',
                'description'=>'edit data in role',
            ],
            //permission
            [
                'name'=>'permission-list',
                'display_name'=>'permission list',
                'description'=>'list permission',
            ],
            [
                'name'=>'permission-index',
                'display_name'=>'permission index',
                'description'=>'index permission',
            ],
            [
                'name'=>'permission-edit',
                'display_name'=>'edit permission',
                'description'=>'edit data in permission',
            ],
            //Log
            [
                'name'=>'log-list',
                'display_name'=>'log list',
                'description'=>'list log',
            ],
            [
                'name'=>'log-index',
                'display_name'=>'log index',
                'description'=>'index log',
            ],
            [
                'name'=>'log-user-index',
                'display_name'=>'log user index',
                'description'=>'index user log',
            ],
            [
                'name'=>'log-create',
                'display_name'=>'create log',
                'description'=>'create us data in log',
            ],
            //setting
            [
                'name'=>'setting-list',
                'display_name'=>'setting list',
                'description'=>'list setting',
            ],
            [
                'name'=>'setting-index',
                'display_name'=>'setting index',
                'description'=>'index setting',
            ],
            [
                'name'=>'setting-create',
                'display_name'=>'create setting',
                'description'=>'create data in setting',
            ],
            [
                'name'=>'setting-edit',
                'display_name'=>'edit setting',
                'description'=>'edit data in setting',
            ],
            //about us
            [
                'name'=>'about-us-list',
                'display_name'=>'about us list',
                'description'=>'list about us',
            ],
            [
                'name'=>'about-us-index',
                'display_name'=>'about us index',
                'description'=>'index about us',
            ],
            [
                'name'=>'about-us-create',
                'display_name'=>'create about us',
                'description'=>'create us data in about',
            ],
            [
                'name'=>'about-us-edit',
                'display_name'=>'edit about us',
                'description'=>'edit data in about us',
            ],
            //contact us
            [
                'name'=>'contact-us-list',
                'display_name'=>'contact us list',
                'description'=>'list contact us',
            ],
            [
                'name'=>'contact-us-index',
                'display_name'=>'contact us index',
                'description'=>'index contact us',
            ],
            [
                'name'=>'contact-us-create',
                'display_name'=>'create contact us',
                'description'=>'create us data in contact us',
            ],
            [
                'name'=>'contact-us-edit',
                'display_name'=>'edit about us',
                'description'=>'edit data in about us',
            ],
            //core data
            [
                'name'=>'core-data-list',
                'display_name'=>'core-data list',
                'description'=>'list core-data',
            ],
            //circle
            [
                'name'=>'circle-list',
                'display_name'=>'circle list',
                'description'=>'list circle',
            ],
            [
                'name'=>'circle-index',
                'display_name'=>'index circle',
                'description'=>'index data in circle',
            ],
            [
                'name'=>'circle-create',
                'display_name'=>'create circle',
                'description'=>'create data in circle',
            ],
            [
                'name'=>'circle-edit',
                'display_name'=>'edit circle',
                'description'=>'edit data in circle',
            ],
            [
                'name'=>'circle-status',
                'display_name'=>'status circle',
                'description'=>'status data in circle',
            ],
            [
                'name'=>'circle-many-status',
                'display_name'=>'status many circle',
                'description'=>'status many data in circle',
            ],
            //area
            [
                'name'=>'area-list',
                'display_name'=>'area list',
                'description'=>'list area',
            ],
            [
                'name'=>'area-index',
                'display_name'=>'index area',
                'description'=>'index data in area',
            ],
            [
                'name'=>'area-create',
                'display_name'=>'create area',
                'description'=>'create data in area',
            ],
            [
                'name'=>'area-edit',
                'display_name'=>'edit area',
                'description'=>'edit data in area',
            ],
            [
                'name'=>'area-status',
                'display_name'=>'status area',
                'description'=>'status data in area',
            ],
            [
                'name'=>'area-many-status',
                'display_name'=>'status many area',
                'description'=>'status many data in area',
            ],
            //social media
            [
                'name'=>'social-media-list',
                'display_name'=>'social media list',
                'description'=>'social media acl',
            ],
            //post
            [
                'name'=>'post-list',
                'display_name'=>'post list',
                'description'=>'list post',
            ],
            [
                'name'=>'post-index',
                'display_name'=>'index post',
                'description'=>'index data in post',
            ],
            [
                'name'=>'post-status',
                'display_name'=>'status post',
                'description'=>'status data in post',
            ],
            [
                'name'=>'post-many-status',
                'display_name'=>'status many post',
                'description'=>'status many data in post',
            ],
            [
                'name'=>'post-status',
                'display_name'=>'status post',
                'description'=>'status data in post',
            ],
            [
                'name'=>'post-many-status',
                'display_name'=>'status many post',
                'description'=>'status many data in post',
            ],
            //commit
            [
                'name'=>'commit-list',
                'display_name'=>'commit list',
                'description'=>'list commit',
            ],
            [
                'name'=>'commit-index',
                'display_name'=>'index commit',
                'description'=>'index data in commit',
            ],
            [
                'name'=>'commit-post-index',
                'display_name'=>'index post commit',
                'description'=>'index post data in commit',
            ],
            [
                'name'=>'commit-status',
                'display_name'=>'status commit',
                'description'=>'status data in commit',
            ],
            [
                'name'=>'commit-many-status',
                'display_name'=>'status many commit',
                'description'=>'status many data in commit',
            ],
            [
                'name'=>'commit-status',
                'display_name'=>'status commit',
                'description'=>'status data in commit',
            ],
            [
                'name'=>'commit-many-status',
                'display_name'=>'status many commit',
                'description'=>'status many data in commit',
            ],
            //Like
            [
                'name'=>'like-list',
                'display_name'=>'like list',
                'description'=>'list like',
            ],
            [
                'name'=>'like-index',
                'display_name'=>'index like',
                'description'=>'index like data',
            ],
            [
                'name'=>'like-index-category',
                'display_name'=>'index like category',
                'description'=>'index like data category',
            ],
            //Api Client
            [
                'name'=>'client',
                'display_name'=>'client',
                'description'=>'client',
            ],
            //Api Nominee
            [
                'name'=>'nominee',
                'display_name'=>'nominee',
                'description'=>'nominee',
            ],
            //friend
            [
                'name'=>'friend-list',
                'display_name'=>'friend list',
                'description'=>'list friend',
            ],
            [
                'name'=>'friend-friend',
                'display_name'=>'friend friend',
                'description'=>'friend friend data',
            ],
            [
                'name'=>'friend-request',
                'display_name'=>'request friend',
                'description'=>'request friend data',
            ],
            //friend
            [
                'name'=>'forgot-password-list',
                'display_name'=>'forgot password list',
                'description'=>'list forgot password',
            ],
            [
                'name'=>'forgot-password',
                'display_name'=>'forgot password ',
                'description'=>'forgot password  data',
            ],
            //call us
            [
                'name'=>'call-us-list',
                'display_name'=>'call us list',
                'description'=>'list call us',
            ],
            [
                'name'=>'call-us-read',
                'display_name'=>'call us read',
                'description'=>'call us read data',
            ],
            [
                'name'=>'call-us-unread',
                'display_name'=>'call us unread',
                'description'=>'call us unread data',
            ],
            [
                'name'=>'call-us-change-status',
                'display_name'=>'call us change status',
                'description'=>'call us change status data',
            ],
            [
                'name'=>'call-us-delete',
                'display_name'=>'call us delete',
                'description'=>'call us delete data',
            ],
            //privacy
            [
                'name'=>'privacy-list',
                'display_name'=>'privacy list',
                'description'=>'list privacy',
            ],
            [
                'name'=>'privacy-index',
                'display_name'=>'privacy index',
                'description'=>'index privacy',
            ],
            [
                'name'=>'privacy-create',
                'display_name'=>'create privacy',
                'description'=>'create us data in about',
            ],
            [
                'name'=>'privacy-edit',
                'display_name'=>'edit privacy',
                'description'=>'edit data in privacy',
            ],
            //import
            [
                'name'=>'import-list',
                'display_name'=>'import list',
                'description'=>'list import',
            ],
            //takeed
            [
                'name'=>'takeed-list',
                'display_name'=>'takeed list',
                'description'=>'list takeed',
            ],
            [
                'name'=>'takeed-form-import',
                'display_name'=>'takeed form import',
                'description'=>'takeed form import',
            ],
            [
                'name'=>'takeed-import',
                'display_name'=>'takeed import',
                'description'=>'takeed import',
            ],
            [
                'name'=>'takeed-index',
                'display_name'=>'takeed index',
                'description'=>'takeed index',
            ],
            //Api takeed
            [
                'name'=>'takeed',
                'display_name'=>'takeed',
                'description'=>'takeed',
            ],
        ];
        foreach ($permissions as $key=>$value)
        {
            Permission::create($value);
        }
    }
}
