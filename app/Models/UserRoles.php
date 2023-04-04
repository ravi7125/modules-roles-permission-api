<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;
    protected $table = 'user_roles';
    protected $fillable = [
        'user_id',
        'role_id',
    ];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function roles()
    {
        return $this->belongsTo(Role::class);
    }
}