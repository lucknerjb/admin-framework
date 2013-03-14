<?php

/**
 * Routes for admin bundle
 */

/**
 * Role filter
 *
 * Restricts access based on role required. Roles with lower weight
 * will be able to access content belonging to roles with higher
 * weight.
 *
 * If 'guest' is given as role name, user will be redirected to
 * dashboard if user is logged in.
 *
 * @param string $role_name
 * @return Response | Redirect
 *
 */
Route::filter('admin.role', function ($role_name) {
    if (! (Auth::check())) {
        return Redirect::to_action('admin::login');
    }
    $role = Admin\Models\Role::where_name($role_name)->first();
    if (Auth::user()->role->weight > $role->weight) {
        return Response::make('Not enough permissions', 403);
    }
});

/**
 * Redirects logged in users to admin dashboard. Used for login page
 */
Route::filter('admin.logged_in', function() {
    if(Auth::check()) {
        return Redirect::to_action('admin');
    }
});

/**
 * Restricts access to users having any of the given permissions
 *
 * @param string $perms
 *   A comma-separated string of permission names
 */
Route::filter('admin.perms', function($perms) {
    if(!(Auth::check())) {
        return Redirect::to_action('admin::login');
    } else {
        // Split string to array
        $perms = array_filter(array_map('trim', explode(',', $perms)));
        $allowed = Admin\Verify::allow_permissions(Auth::user(), $perms);
        if ( ! ($allowed)) {
            return Redirect::to_action('admin::users')
                ->with('error', "You don't have required access permissions.");
        }
    }
});

/**
 * Artisan command line from web. Modified for Admin bundle
 *
 * Source: https://github.com/joecwallace/laravel-artisan-bundle
 */
Route::get('(:bundle)/artisan/(:all?)',
           array('before' => 'admin.role:Admin', function($params = null) {
               $well = function($header, $code) {
                   return View::make('admin::artisan.well', array(
                                         'header' => $header,
                                         'code'   => $code,
                                         ));
               };

               if (empty($params)) {
                   $examples = array(
                       URL::current() . '/bundle+task.method/param',
                       URL::current() . '/bundle+task',
                       URL::current() . '/task.method',
                       URL::current() . '/migrate',
                       URL::current() . '/migrate.reset',
                       );
                   return $well('Try something like this',
                                implode('<br />', $examples));
               }

               $args = str_replace(
                   array('+', '.'),
                   array('::', ':'),
                   explode('/', $params)
                   );

               $ret = $well('Equivalent command',
                            'php artisan ' . implode(' ', $args));

               ob_start();

               try
                   {
                       require path('sys').'cli/dependencies'.EXT;
                       Laravel\CLI\Command::run($args);
                   }
               catch (Exception $ex)
                   {
                       echo $ex->getMessage();
                   }

               $output = str_replace(PHP_EOL, '<br />', ob_get_contents());
               ob_end_clean();

               $ret .= $well('Output', $output);

               return $ret;
           }));

// --- End artisan command web interface

/**
 * Controller registration
 */
Route::controller(array('admin::home',
                        'admin::users',
                        'admin::login',
                        'admin::logout',
                        'admin::profile'));


/**
 * View composers
 */

// Admin main menu view
View::composer('admin::partials.main_menu', function ($view) {
    $admin_nav = new Admin\Menu('admin_nav');
    // Fire admin.nav event
    Event::fire('admin.nav', array(&$admin_nav));
    // Pass data to view as html
    $view->with('admin_nav', $admin_nav->to_html());
});

// Admin tabs view. Adding items will be same as admin.nav event,
// except that listeners should be attached in controllers
View::composer('admin::partials.tabs', function ($view) {
    $admin_tabs = new Admin\Menu('admin_tabs');
    // Fire admin.nav event
    Event::fire('admin.tabs', array(&$admin_tabs));
    // Pass data to view as html
    $view->with('admin_tabs', $admin_tabs->to_html());
});

/**
 * admin.extension event
 *
 * Registers controllers of other bundles as routes for admin
 */
$admin_ext = new Admin\Extension;
Event::fire('admin.ext', array(&$admin_ext));
//Register extension routes
foreach ($admin_ext->list as $item) {
    Route::any('(:bundle)/' . $item['path'] . '/(:any?)',
               array(
                   'before' => 'admin.role:' . $item['role'],
                   function ($page = 'index') use ($item)
                   {
                       return Controller::call($item['method'] . '@' . $page);
                   }));
}