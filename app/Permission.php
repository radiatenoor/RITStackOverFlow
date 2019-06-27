<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function admins(){
        return $this->belongsToMany(Admin::class,'admin_permission','permission_id','admin_id');
    }
}
