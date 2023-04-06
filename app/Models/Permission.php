<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name' ,
        'description'
    ];

    
     // Many-To-Many Permission_Modules Relationship

    public function modules()
   {
        return $this->belongsToMany(Modules::class,'module__permissions','modules_id','permission_id')->withPivot(['modules_id','permission_id','add_access','view_access','edit_access','delete_access']);
    }

    public function access()
   {
      return $this->hasMany(Module_Permission::class);
    }

    public function role()
   {
        return $this->belongsToMany(Role::class,'role_permissions','permission_id','role_id');
    }

    public function permission()
   {
         return $this->belongsToMany(Permission::class);
    }

    //middleware foreach logic..

    public function hasAccess($jobType, $access)
    {
      
        foreach ($this->modules as $modules) {     
            $module__permission = $modules->where('name', $jobType)->first();
            $getPivot = $modules->pivot->where('id',$module__permission->id)->where($access,true)->first();
            if ($module__permission && $getPivot) {
                return true;
            }
        }
        return false;
    }

}
