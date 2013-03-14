<?php

/**
 * Admin Logout page
 */
class Admin_Logout_Controller extends Admin_Base_Controller {

    /**
     * Serve admin logout page
     */
    public function get_index()
    {
        Auth::logout();
        return Redirect::home()->with('status', 'You have been logged out.');
    }

}
