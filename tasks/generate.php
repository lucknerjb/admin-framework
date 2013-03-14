<?php

use Admin\Models\Permission as Permission;
use Admin\Models\Role as Role;
use Admin\Models\User as User;

/**
 * Initial data generator for admin bundle
 */
class Admin_Generate_Task {

    /**
     * Common code run for each method in the class
     */
    public function __construct()
    {
        if (User::count() > 0 || Role::count() > 0 ||
            Permission::count() > 0) {
            print "Generate task should be run on a clean migration... Exiting\n";
            exit;
        }
    }

    /**
     * Default action which responds to admin::generate
     */
    public function run()
    {
        $this->permissions();
        $this->roles();
        $this->admin();
        print "[Finished]\n";
    }

    /**
     * Generate permissions
     */
    private function permissions()
    {
        print "Generating permissions...\n";
        $data = array(
            array(
                'name' => 'Manage Users',
                'description' => 'Access user management in admin panel',
                ),
            array(
                'name' => 'Manage Pages',
                'description' => 'Access page management in admin panel',
                ),
            array(
                'name' => 'Manage Categories',
                'description' => 'Access category management in admin panel',
                ),
            array(
                'name' => 'Manage Menu',
                'description' => 'Access menu management in admin panel',
                ),
            );
        foreach ($data as $row) {
            $perm = new Permission($row);
            $perm->save();
        }
    }

    /**
     * Generate roles
     */
    private function roles()
    {
        print "Generating roles...\n";
        $data = array(
            array(
                'name' => 'Admin',
                'description' => 'Admins have all permissions',
                'weight' => '0',
                'perms' => Permission::all(),
                ),
            array(
                'name' => 'Moderator',
                'description' => 'Moderators have access to pages and categories',
                'weight' => '5',
                'perms' => Permission::where_in('name',
                                                array('Manage Pages',
                                                      'Manage Categories'
                                                    ))->get(),
                ),
            array(
                'name' => 'Content Editor',
                'description' => 'Content editors have access to pages',
                'weight' => '10',
                'perms' => Permission::where_in('name',
                                                array('Manage Pages'))->get(),
                ),
            array(
                'name' => 'Normal',
                'description' => 'Normal users can change profile information',
                'weight' => '15',
                'perms' => array(),
                ),
            );
        foreach ($data as $row) {
            $role = new Role(array('name' => $row['name'],
                                   'description' => $row['description'],
                                   'weight' => $row['weight']));
            $role->save();
            foreach($row['perms'] as $perm) {
                $role->permissions()->attach($perm->id);
            }
        }
    }

    /**
     * Generate an admin user
     */
    private function admin()
    {
        print "Generating 'admin' user...\n";
        $role = Role::where_name('Admin')->first();
        $admin = new User(array('name' => 'Admin',
                                'username' => 'admin',
                                'email' => 'mail@example.com',
                                'password' => 'admin',
                                'role_id' => $role->id,
                              ));
        $admin->save();
        print "...Created user: admin, pass: admin...\n";
    }
}