<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\Model;

class Takeed extends Model
{
    protected $fillable = [
        'family_name','name','first_name','second_name','third_name','forth_name','family_name_one','table_area','table_gender','internal_reference'
        ,'civil_reference','birth_day','job','address','registration_status','registration_number','registration_data','circle'
    ];
    public function circle1()
    {
        return $this->belongsTo('App\Models\Core_Data\Circle','circle');
    }
    protected $table = 'takeeds';


    public $timestamps = true;

}