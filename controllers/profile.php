<?php

/**
 * Admin Profile page
 */
class Admin_Profile_Controller extends Admin_Base_Auth_Controller {

    /**
     * Serve admin profile page
     */
    public function get_index()
    {
        return View::make('admin::profile.profile', $this->data);
    }

    /**
     * Handles POST from profile form
     */
    public function post_index()
    {
        // Validation rules
        $rules = array(
            'name' => 'required|max:100',
            'password' => 'confirmed',
            'password_confirmation' => 'required_with:password'
            );
        if ($this->data['user']->email !== Input::get('email')) {
            $rules['email'] = 'required|email|unique:users';
        }
        // Prepare validation
        $validation = Validator::make(Input::all(), $rules);
        // Run validation
        if($validation->fails()) {
            return Redirect::to(URL::current())->with_errors($validation)
                ->with_input();
        } else {
            $user = Admin\Models\User::find($this->data['user']->id);
            $user->name = trim(strip_tags(Input::get('name')));
            $user->email = trim(strip_tags(Input::get('email')));
            if (strlen(Input::get('password')) > 0) {
                $user->password = trim(Input::get('password'));
            }
            $update = $user->save();

            // Check if update was successful
            if ($update) {
                return Redirect::to_action('admin')
                    ->with('success', 'Successfully updated profile.');
            } else {
                return redirect::to(URL::current())
                    ->with('error', 'Unable to update profile.');
            }
        }
    }

}