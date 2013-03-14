<?php
namespace Admin\Models;

use \Laravel\Hash as Hash;

/**
 * Provides an Eloquent model for users
 */
class User extends \Eloquent {

    public static $timestamps = true;

    /**
     * Hide sensitive information
     */
    public static $hidden = array('password');

    /**
     * Relate to roles
     */
    public function role()
    {
        return $this->belongs_to('Admin\Models\Role');
    }

    /**
     * Setter for password
     */
    public function set_password($pass)
    {
        $this->set_attribute('password', Hash::make($pass));
    }
}