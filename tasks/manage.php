<?php

use Admin\Models\Permission as Permission;
use Admin\Models\Role as Role;

class Admin_Manage_Task {

    /**
     * Update all permissions for admin role
     */
    public function update_admin_permissions()
    {
        print "Updating Admin permissions...\n";
        $admin = Role::where_name('Admin')->first();
        $perms = Permission::all();
        $perms_array = array();
        foreach ($perms as $row) {
            $perms_array[] = $row->id;
        }
        if (! is_null($admin)) {
            $admin->permissions()->sync($perms_array);
        }
    }
}