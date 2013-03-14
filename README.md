Admin framework for Laravel
===========================

This bundle provides an admin framework for Laravel 3.

It does not provide any ready-to-use component. Any bundle or
application using the admin framework needs to provide its own admin
pages. Using the admin framework's pluggable interface, those pages
can be served from the admin interface with proper role and
permissions.

See `admin.json` to know how to plugin to the Events offered by the
admin framework.

Installation
------------

- Git clone or copy the bundle to Laravel's `bundles` directory with
  the name of `admin`.

    ```sh
    $ git clone git@github.com:codebinders/laravel-admin-framework admin
    ```

- Edit `application/config/auth.php` and put the following values:

    - `'driver' => 'eloquent'`
    - `'username' => 'username'`
    - `'password' => 'password'`
    - `'model' => 'Admin\Models\User'`
    - `'table' => 'users'`

- Set a session driver for Laravel

- Edit `application/bundles.php` and register the Admin bundle at the
  top of all bundles:

    ```php
    'admin' => array('handles' => 'admin', 'auto' => true),
    ```

- Load stock data. Run this command in Laravel's project directory:

    ```sh
    php artisan migrate:admin
    php artisan admin::generate
    php artisan bundle:publish admin
    ```

- Navigate to `/admin` and login with username: `admin` and password: `admin`

License
-------

Released under the terms of the GNU General Public License v3+. For
full license text see: http://www.gnu.org/licenses/gpl.txt
