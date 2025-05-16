<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Helper functions for sidebar menu generation
 */

if (!function_exists('is_menu_active')) {
    /**
     * Check if the current menu is active
     *
     * @param string $segment URI segment to check
     * @param string $menu_url Menu URL to compare with
     * @return string 'active' if menu is active, empty string otherwise
     */
    function is_menu_active($segment, $menu_url)
    {
        $CI = &get_instance();
        
        // For dashboard (home), special case
        if (($menu_url == 'dashboard' || $menu_url == '') && ($segment == 'dashboard' || $segment == '')) {
            return 'active';
        }
        
        // For normal menu items
        if ($segment == $menu_url || strpos($segment, $menu_url) === 0) {
            return 'active';
        }
        
        return '';
    }
}

if (!function_exists('is_parent_active')) {
    /**
     * Check if a parent menu should be shown as active/open
     *
     * @param array $sub_menu Array of submenu items
     * @return string 'menu-is-opening menu-open' if parent menu is active, empty string otherwise
     */
    function is_parent_active($sub_menu)
    {
        $CI = &get_instance();
        $current_segment = $CI->uri->segment(1);
        
        foreach ($sub_menu as $menu) {
            $menu_url_parts = explode('/', $menu->menu_url);
            $menu_segment = $menu_url_parts[0];
            
            if ($current_segment == $menu_segment) {
                return 'menu-is-opening menu-open';
            }
        }
        
        return '';
    }
}

if (!function_exists('is_parent_active_class')) {
    /**
     * Check if a parent menu link should have active class
     *
     * @param array $sub_menu Array of submenu items
     * @return string 'active' if parent menu is active, empty string otherwise
     */
    function is_parent_active_class($sub_menu)
    {
        $CI = &get_instance();
        $current_segment = $CI->uri->segment(1);
        
        foreach ($sub_menu as $menu) {
            $menu_url_parts = explode('/', $menu->menu_url);
            $menu_segment = $menu_url_parts[0];
            
            if ($current_segment == $menu_segment) {
                return 'active';
            }
        }
        
        return '';
    }
}