<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'role_permissions';
    
    protected $fillable = [
        'role_id',
        'permission_id',
        'created_at',
        'updated_at',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
    public function roles()
    {
    return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
    return $this->belongsToMany(Permission::class);
    }
    }
