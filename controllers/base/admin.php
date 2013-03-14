<?php

/**
 * Restricts certain features to Admins only
 */
class Admin_Base_Admin_Controller extends Admin_Base_Auth_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->filter('before', 'admin.role:Admin');
    }

}