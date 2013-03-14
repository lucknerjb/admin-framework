<?php

/**
 * Extends Controller to add admin specific code
 */
class Admin_Base_Controller extends Controller {

    /**
     * Use restful controllers
     */
    public $restful = true;

    /**
     * Set data array with default title.
     *
     * This data array will be passed to all views. Any data that
     * needs to be bound to a view should be added as an item to this
     * array
     */
    public $data = array('title' => 'Admin');

    /**
     * Add useful inheritable stuff
     */
    public function __construct()
    {
        parent::__construct();
        // Run CSRF filter on all posts
        $this->filter('before', 'csrf')->on('post');
        // Load assets
        Asset::container('header')->bundle('admin');
        Asset::container('header')->add('admincss', 'css/admin.css');
        Asset::container('header')->add('bootstrap', 'css/bootstrap.min.css');
        Asset::container('header')->add('bootstrap-responsive',
                                        'css/bootstrap-responsive.min.css');
        Asset::container('footer')->bundle('admin');
        Asset::container('footer')->add('jquery', 'js/jquery-1.9.1.min.js');
        Asset::container('footer')->add('bootstrapjs', 'js/bootstrap.min.js');
        Asset::container('footer')->add('ckeditor', 'addons/ckeditor/ckeditor.js');
    }

    /**
     * Catch-all method for requests that can't be matched.
     *
     * @param  string    $method
     * @param  array     $parameters
     * @return Response
     */
    public function __call($method, $parameters)
    {
        return Response::error('404');
    }

}