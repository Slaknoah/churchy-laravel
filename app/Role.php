<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    private $permissions;

    /**
     * User relationship
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Check if role has enough pemissions to
     */
    public function hasAccess(array $permissions)
    {
        foreach($permissions as $permission)
        {
            if($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    protected function hasPermission(string $permission) {
        $permissions = json_decode( $this->permissions, true );
        return $permissions[$permission]??false;
    }
}
