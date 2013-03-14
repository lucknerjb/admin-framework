<?php

use Admin\Models\User;
use Admin\Models\Role;
use Admin\Models\Permission;

/**
 * Admin Users Controller
 */
class Admin_Users_Controller extends Admin_Base_Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        Event::listen('admin.tabs', function (&$admin_tabs) {
            $tab_items = array(
                array('User Management', 'admin::users'),
                array('Create User', 'admin::users.create'),
                array('Roles', 'admin::users.roles'),
                );
            foreach($tab_items as $row) {
                $admin_tabs->add($row);
            }
        });
    }

    /**
     * User management landing
     */
    public function get_index()
    {
        $this->data['search'] = true;
        $this->data['q'] = trim(strip_tags(urldecode(Input::get('q'))));
        $this->data['users'] = User::with('role')
            ->where('name', 'LIKE', '%' . $this->data['q'] . '%')
            ->paginate(10);
        return View::make('admin::users.index', $this->data);
    }

    /**
     * User creation form
     */
    public function get_create()
    {
        $this->data['roles'] = Role::order_by('weight', 'desc')->get();
        return View::make('admin::users.create', $this->data);
    }

    /**
     * Handles POST from user creation form
     */
    public function post_create()
    {
        // Validation rules
        $rules = array(
            'name' => 'required|max:100',
            'username' => 'required|alpha_dash|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required_with:password',
            'role' => 'required|integer|exists:roles,id',
            );
        // Prepare validation
        $validation = Validator::make(Input::all(), $rules);
        // Run validation
        if($validation->fails()) {
            return Redirect::to(URL::current())->with_errors($validation)
                ->with_input();
        } else {
            // Validation passed. Create user
            $role = Role::find(Input::get('role'));
            $user = new User(array(
                                 'name' => Input::get('name'),
                                 'username' => Input::get('username'),
                                 'email' => Input::get('email'),
                                 'password' => Input::get('password'),
                                 ));
            $insert = $role->users()->insert($user);
            if ($insert) {
                return Redirect::to_action('admin::users')
                    ->with('success', 'Successfully created user: '
                           . Input::get('username'));
            } else {
                return redirect::to(URL::current())
                    ->with('error', 'Unable to create user');
            }
        }
    }

    /**
     * User Roles
     */
    public function get_roles()
    {
        $this->data['roles'] = Role::with('permissions')
            ->order_by('weight', 'asc')->get();
        return View::make('admin::users.roles', $this->data);
    }

}