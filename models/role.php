<?php
namespace Admin\Models;

/**
 * Provides an Eloquent model for roles
 */
class Role extends \Eloquent {

    /**
     * Set default timestamps to true
     */
    public static $timestamps = true;

    /**
     * Many-to-Many relation with Admin\Models\Permission
     */
    public function permissions()
    {
        return $this->has_many_and_belongs_to('Admin\Models\Permission');
    }

    /**
     * Many-to-One relation with Admin\Models\User
     */
    public function users()
    {
        return $this->has_many('Admin\Models\User');
    }
}