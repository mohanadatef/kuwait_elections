<?php

namespace App;
use App\Models\ACL\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class User extends Authenticatable implements JWTSubject
{

    use  EntrustUserTrait;
    use Notifiable;

    protected $fillable = [
         'email','status','password','remember_token','mobile','birth_day','gender','job','circle_id','area_id','about','degree',
        'family_name','name','first_name','second_name','third_name','forth_name','internal_reference','civil_reference','address',
        'registration_status','registration_number','registration_data','status_login'
    ];

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id','role_id')->withTimestamps('created_at','updated_at');
    }
        public function role_information()
    {
        return $this->belongsToMany('App\Models\ACL\Role_user');
    }
    public function log()
    {
        return $this->hasMany('App\Models\ACL\Log');
    }
    public function circle()
    {
        return $this->belongsTo('App\Models\Core_Data\Circle','circle_id');
    }
    public function area()
    {
        return $this->belongsTo('App\Models\Core_Data\Area','area_id');
    }
    public function post()
    {
        return $this->hasMany('App\Models\Social_Media\Post');
    }
    public function like_post()
    {
        return $this->hasMany('App\Models\Social_Media\Like');
    }
    public function commit_post()
    {
        return $this->hasMany('App\Models\Social_Media\Commit');
    }
    public function like_commit()
    {
        return $this->hasMany('App\Models\Social_Media\Like');
    }
    public function user_send_friend()
    {
        return $this->hasMany('App\Models\ACL\Friend','user_send_id');
    }
    public function user_receive_friend()
    {
        return $this->hasMany('App\Models\ACL\Friend','user_receive_id');
    }
    public function image()
    {
        return $this->hasMany('App\Models\Image','category_id');
    }
    public function profile_image()
    {
        return $this->belongsTo('App\Models\Image','category_id');
    }
    public function forgot_password()
    {
        return $this->hasMany('App\Models\ACL\Forgot_Password');
    }
    public function group_user()
    {
        return $this->hasMany('App\Models\Social_Media\Group');
    }
    public function nominee()
    {
        return $this->belongsTo('App\Models\Election\Election','nominee_id');
    }
    public function user_send_notification()
    {
        return $this->hasMany('App\Models\Setting\Notification','user_send_id');
    }
    public function user_receive_notification()
    {
        return $this->hasMany('App\Models\Setting\Notification','user_receive_id');
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $table = 'users';
    public $timestamps = true;



}
