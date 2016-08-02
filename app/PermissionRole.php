<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = 'permission_role';
    public $timestamps = false;

    protected $fillable = [
        'permission_id', 'role_id'
    ];

    public function Permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function Role()
    {
        return $this->belongsTo(Role::class);
    }

}
