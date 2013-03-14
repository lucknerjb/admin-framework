<?php namespace Admin;

use \URL;
use \Auth;

/**
 * Provides a flexible Menu class
 *
 * @code
 * // Create a Menu instance
 * $menu = new Admin\Menu('mymenu',
 *   array(array('Admin', 'admin', 'Admin'),
 *         array('Login', 'admin::login', 'Guest'),
 *   ));
 * // Print menu items as html
 * echo $menu->to_html();
 *
 * @param string $menu_name
 * @param array $menu_items
 *   $menu_items should be an array of arrays, where each sub-array
 *   should have the structure:
 *       array(name, action, role)
 */
class Menu {

    /**
     * Name of the menu
     */
    public $name = null;

    /**
     * Items of menu
     */
    public $items = array();

    /**
     * Initialize Menu instance
     */
    public function __construct($menu_name, $menu_items = array())
    {
        $this->name = $menu_name;
        foreach ($menu_items as $key => $item) {
            $this->items[$key] = $item;
            if( ! (isset($item[2]))) {
                $this->items[$key][2] = 'Guest';
            }
            if (URL::current() == URL::to_action($item[1])) {
                $this->items[$key][3] = true;
            } else {
                $this->items[$key][3] = false;
            }
        }
    }

    /**
     * Add items to menu
     *
     * @param array $item
     */
    public function add($item)
    {
        if (is_array($item) and count($item) >= 2) {
            if( ! (isset($item[2]))) {
                $item[2] = 'Guest';
            }
            if (URL::current() == URL::to_action($item[1])) {
                $item[3] = true;
            } else {
                $item[3] = false;
            }
            $this->items[] = $item;
        } else {
            throw new Exception('Method should get an array of at least two members');
        }
    }

    /**
     * Count number of items in menu
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Render items as a list.
     *
     * Note: This method prints only the <li> elements. In a view,
     * they should be wrapped with a <ul> element.
     */
    public function to_html()
    {
        $output = '';
        foreach ($this->items as $item) {
            if (Verify::allow_role(Auth::user(), $item[2])) {
                $class = ($item[3] == true) ? 'active' : '';
                $output .= '<li class="' . $class . '">';
                $output .= '<a href="' . URL::to_action($item[1]) . '">';
                $output .= $item[0];
                $output .= '</a></li>';
            }
        }
        return $output;
    }
}
