<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Helper functions for checking user access
 */

if (!function_exists('check_menu_access')) {
    /**
     * Check if the user has access to a specific menu
     *
     * @param string $menu_url Menu URL to check
     * @return bool True if user has access, false otherwise
     */
    function check_menu_access($menu_url)
    {
        $CI = &get_instance();
        $CI->load->model('Menu_model');
        
        // Get user group
        $user_group_id = $CI->session->userdata('group');
        
        // Get all menu items for this user group
        $menu_items = $CI->Menu_model->get_menu_by_group_id($user_group_id);
        
        // Check main menu items
        foreach ($menu_items as $menu) {
            if ($menu['menu_url'] == $menu_url) {
                return true;
            }
            
            // Check submenu items
            if ($menu['is_parent'] && !empty($menu['sub_menu'])) {
                foreach ($menu['sub_menu'] as $submenu) {
                    if ($submenu->menu_url == $menu_url) {
                        return true;
                    }
                }
            }
        }
        
        return false;
    }
}

if (!function_exists('restrict_access')) {
    /**
     * Restrict access to specific pages
     *
     * @param string $menu_url Menu URL to check
     * @return void
     */
    function restrict_access($menu_url)
    {
        $CI = &get_instance();
        
        // Administrators always have access
        if ($CI->session->userdata('group') == 1) {
            return;
        }
        
        // Check if user has access to this menu
        if (!check_menu_access($menu_url)) {
            $CI->session->set_flashdata('error', 'You do not have permission to access this page.');
            redirect('dashboard');
        }
    }
}