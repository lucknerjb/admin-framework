<?php

/**
 * Admin Login page
 */
class Admin_Login_Controller extends Admin_Base_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->filter('before', 'admin.logged_in');
        $tab_items = array(
            array('Login', 'admin::login'),
            array('Back to site', '/'),
            );
        $tabs = new Admin\Menu('tabs', $tab_items);
        $this->data['tabs'] = $tabs->to_html();
    }

    /**
     * Serve admin login page
     */
    public function get_index(){
        return View::make('admin::login.index', $this->data);
    }

    /**
     * Process data posted from login form
     */
    public function post_index(){
        $creds = array(
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            );
        if (Auth::attempt($creds)) {
            return Redirect::to(URL::to_action('admin::home@index'));
        } else {
            return Redirect::back()
                ->with('error', 'Invalid username or password');
        }
    }
}
