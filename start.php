<?php

/**
 * Code executed when bundle is started
 */

// Shortcut to map
$path = Bundle::path('admin');

// Create autoloader map
Autoloader::map(
    array(
        'Admin_Base_Controller' => $path . 'controllers/base/base.php',
        'Admin_Base_Admin_Controller' => $path . 'controllers/base/admin.php',
        'Admin_Base_Auth_Controller' => $path . 'controllers/base/auth.php',
        )
    );

// Create autoloader namespaces
Autoloader::namespaces(
    array(
        'Admin\Models' => $path . 'models',
        'Admin' => $path . 'libraries',
        )
    );

// Load extensions and admin nav elements
$bundles = \Bundle::names();
foreach ($bundles as $name) {
    $json_path = \Bundle::path($name) . 'admin.json';
    $json = null;
    // Load file as json array
    if (file_exists($json_path)){
        $json = json_decode(file_get_contents($json_path), true);
    }
    if ($json !== null) {
        // If 'nav' is specified, load nav elements
        if (isset($json['nav'])) {
            // Hook into admin.nav event
            Event::listen('admin.nav', function (&$admin_nav) use ($json) {
                foreach ($json['nav'] as $nav) {
                    $admin_nav->add(array($nav[0], $nav[1], $nav[2]));
                }
            });
        }
        // If 'ext' is specified, load ext elements
        if (isset($json['ext'])) {
            // Hook into admin.ext event
            Event::listen('admin.ext', function (&$admin_ext) use ($json) {
                foreach ($json['ext'] as $ext) {
                    $admin_ext->add(array('path' => $ext['path'],
                                          'method' => $ext['method'],
                                          'role' => $ext['role']));
                }
            });
        }
    }
}