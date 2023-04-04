<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module_Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        'modules_id',     
        'delete_access', 
        'add_access', 
        'view_access',
        'edit_access'        
      
    ];
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
