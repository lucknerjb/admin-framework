<?php namespace Admin;

/**
 * Admin Extension class
 *
 * Provides a class for storing extension information. Extensions can
 * plug-in to admin bundle using by adding information to the
 * Extension class.
 */
class Extension {

    /**
     * List of extensions
     */
    public $list = array();

    /**
     * Adds to Extension::list
     */
    public function add(array $info)
    {
        $this->list[] = array(
            'path' => $info['path'],
            'method' => $info['method'],
            'role' => $info['role'],
            );
    }

}