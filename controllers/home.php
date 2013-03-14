<?php

/**
 * Admin Home page
 */
class Admin_Home_Controller extends Admin_Base_Auth_Controller {

    /**
     * Serve admin home page
     */
    public function get_index()
    {
        return View::make('admin::dashboard.dashboard', $this->data);
    }

}
