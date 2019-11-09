<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get messages associated with the user(author)
     */
    public function authorMessages() {
        return $this->hasMany('App\Message', 'author_id');
    }

    /**
     * Get messages associated with the user(speaker)
     */
    public function speakerMessages() {
        return $this->hasMany('App\Message', 'speaker_id');
    }

    /**
     * Author article
     */
    public function articles() {
        return $this->hasMany('App\Article', 'author_id');
    }

    /**
     * List user article drafts
     */
    public function articleDrafts() {
        return $this->articles()->where('published', false)->get();
    }

    /**
     * Check if user has any article draft
     */
    public function hasArticleDraft() {
        return null !== $this->articles()->where('published', false)->first();
    }

    /**
     * Author pages
     */
    public function pages() {
        return $this->hasMany('App\Page', 'author_id');
    }

    /**
     * Role relationship
     */
    public function roles() {
        return $this->belongsToMany('App\Role');
    }

    /**
     * Get message meta
     */
    public function metas() {
        return $this->hasMany('App\Postmeta', 'post_id');
    }

    /**
     * Authorizing roles for users
     */
    public function authorizeRoles($roles) {

        if(is_array($roles)) {
            return $this->hasAnyRole($roles) ||
                abort(401, 'This action is unauthorized.');
        }

        return $this->hasRole($roles) ||
            abort(401, 'This action is unauthorized');
    }

    /**
     * Check multiple roles
     */
    public function hasAnyrole($roles) {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    /**
     * Check one role
     */
    public function hasRole($role) {
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
     * Check if user has access to permissions
     */
    public function hasAccess(array $permissions) {
        foreach($this->roles as $role ) {
            if($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Return user permissions based on their roles
     */
    public function getAllPermissions() {
        $permissions = [];
        foreach( $this->roles()->get() as $role) {
            $rolePermissions = json_decode( $role->permissions, true );
            if ($rolePermissions) {
                foreach ($rolePermissions as $permission => $value) {
                    if (!array_key_exists($permission, $permissions))
                        $permissions[$permission] = $value;
                }
            }
        }
        return $permissions;
    }

}
