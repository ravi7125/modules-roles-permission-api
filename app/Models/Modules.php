<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{


    use HasFactory;

    protected $fillable = [
        'name' ,
        'description'
    ];
   
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withPivot('add_access', 'delete_access', 'view_access', 'edit_access');
    }
}
