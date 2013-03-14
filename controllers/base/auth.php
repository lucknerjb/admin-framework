<?php

/**
 * Adds authentication to admin
 */
class Admin_Base_Auth_Controller extends Admin_Base_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->filter('before', 'admin.role:Normal');
        $this->data['user'] = Auth::user();
    }

}