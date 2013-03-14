<?php namespace Admin;

use Admin\Models\User;
use Admin\Models\Role;
use \Redirect;
use \Auth;

/**
 * Checks roles and permissions for user
 */
class Verify {

    /**
     * Checks if user's role is the given role
     *
     * @param User | null $user
     *   A User object or null
     * @param string $role
     *   Name of the role
     * @return bool
     */
    public static function role_is($user, $role)
    {
        if ($user == null) return false;
        if ($user->role->name == $role) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if user's role has given permission
     *
     * @param User | null $user
     *   A User object or null
     * @param string $perm
     *   Name of the permission
     * @return bool
     */
    public static function has_permission($user, $perm)
    {
        if ($user == null) return false;
        $perms = $user->role->permissions;
        foreach ($perms as $row) {
            if ($row->name == $perm) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if user's role has all given permissions
     *
     * @param User | null $user
     *   A User object or null
     * @param array $perms
     *   Array of permission names
     * @return bool
     */
    public static function has_permissions($user, $perms)
    {
        if ($user == null) return false;
        $perm_names = array();
        foreach($user->role->permissions as $row) {
            $perm_names[] = $row->name;
        }
        if (count(array_diff($perms, $perm_names)) == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Allow access for any of the given permissions
     *
     * @param User | null $user
     *   A User object or null
     * @param array $perms
     *   Array of permission names
     * @return bool
     */
    public static function allow_permissions($user, $perms)
    {
        if ($user == null) return false;
        $perm_names = array();
        foreach($user->role->permissions as $row) {
            $perm_names[] = $row->name;
        }
        if (count(array_intersect($perms, $perm_names)) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Allow access for given role
     *
     * @param User | null $user
     *   A User object or null
     * @param array $role_name
     *   Role name
     * @return bool
     */
    public static function allow_role($user, $role_name)
    {
        if ($user == null) return false;
        // Always allow for guest role or empty role name
        if (strtolower($role_name) == 'guest' or
            strlen($role_name) === 0) return true;
        // Process for others
        $role = Role::where_name($role_name)->first();
        //Check invalid role
        if ($role === null) return false;
        // Otherwise process weight of role
        if (Auth::user()->role->weight > $role->weight) {
            return false;
        } else {
            return true;
        }
    }
}
