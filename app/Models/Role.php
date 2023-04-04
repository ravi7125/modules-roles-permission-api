<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    

    public function permission(){
        return $this->belongsToMany(Permission::class,'role_permissions','role_id','permission_id');
    }
//role_permission relationship

     public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }

//user_role relationship
    public function users() {

        return $this->belongsToMany(User::class,'user_roles','user_id','role_id');
            
     }

     //middleware foreach logic..
     public function hasAccess($jobType, $access)
     {
         foreach ($this->permission as $permission) {         
             if ($permission->hasAccess($jobType, $access)) {             
                 return true;
             }
         }
     }
    
}
