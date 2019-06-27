<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    public function permissions(){
        return $this->belongsToMany(Permission::class,'admin_permission','admin_id','permission_id');
    }
}
