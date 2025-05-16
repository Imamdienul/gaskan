<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all menu items for a specific user group
     *
     * @param int $group_id User group ID
     * @return array Menu items that user group has access to
     */
    public function get_menu_by_group_id($group_id)
    {
        // Get parent menus
        $this->db->select('m.*');
        $this->db->from('menu_items m');
        $this->db->join('menu_access a', 'm.id_menu = a.id_menu');
        $this->db->where('a.id_group_user', $group_id);
        $this->db->where('m.parent_id IS NULL');
        $this->db->order_by('m.menu_order', 'ASC');
        $query = $this->db->get();
        $parent_menus = $query->result();

        $menu_structure = array();

        foreach ($parent_menus as $parent) {
            $menu_item = [
                'id_menu' => $parent->id_menu,
                'menu_name' => $parent->menu_name,
                'menu_url' => $parent->menu_url,
                'menu_icon' => $parent->menu_icon,
                'is_parent' => $parent->is_parent,
                'sub_menu' => []
            ];

            // If this is a parent menu, fetch its child menus
            if ($parent->is_parent) {
                $this->db->select('m.*');
                $this->db->from('menu_items m');
                $this->db->join('menu_access a', 'm.id_menu = a.id_menu');
                $this->db->where('a.id_group_user', $group_id);
                $this->db->where('m.parent_id', $parent->id_menu);
                $this->db->order_by('m.menu_order', 'ASC');
                $query = $this->db->get();
                $menu_item['sub_menu'] = $query->result();
            }

            $menu_structure[] = $menu_item;
        }

        return $menu_structure;
    }

    /**
     * Get all menu items
     *
     * @return array All menu items
     */
    public function get_all_menu_items()
    {
        $this->db->select('*');
        $this->db->from('menu_items');
        $this->db->order_by('parent_id', 'ASC');
        $this->db->order_by('menu_order', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get all parent menu items
     *
     * @return array Parent menu items
     */
    public function get_parent_menu_items()
    {
        $this->db->select('*');
        $this->db->from('menu_items');
        $this->db->where('parent_id IS NULL');
        $this->db->order_by('menu_order', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Check if a user group has access to a specific menu item
     *
     * @param int $group_id User group ID
     * @param int $menu_id Menu item ID
     * @return bool True if group has access, false otherwise
     */
    public function check_access($group_id, $menu_id)
    {
        $this->db->where('id_group_user', $group_id);
        $this->db->where('id_menu', $menu_id);
        $result = $this->db->get('menu_access');
        return $result->num_rows() > 0;
    }

    /**
     * Add menu access for a user group
     *
     * @param int $group_id User group ID
     * @param int $menu_id Menu item ID
     * @return bool True if successful, false otherwise
     */
    public function add_access($group_id, $menu_id)
    {
        $data = [
            'id_group_user' => $group_id,
            'id_menu' => $menu_id
        ];
        return $this->db->insert('menu_access', $data);
    }

    /**
     * Remove menu access for a user group
     *
     * @param int $group_id User group ID
     * @param int $menu_id Menu item ID
     * @return bool True if successful, false otherwise
     */
    public function remove_access($group_id, $menu_id)
    {
        $this->db->where('id_group_user', $group_id);
        $this->db->where('id_menu', $menu_id);
        return $this->db->delete('menu_access');
    }

    /**
     * Get menu access for a specific user group
     *
     * @param int $group_id User group ID
     * @return array Menu items with access status
     */
    public function get_menu_access_by_group($group_id)
    {
        $all_menus = $this->get_all_menu_items();
        
        foreach ($all_menus as $menu) {
            $menu->has_access = $this->check_access($group_id, $menu->id_menu);
        }
        
        return $all_menus;
    }

    /**
     * Add a new menu item
     *
     * @param array $data Menu item data
     * @return bool True if successful, false otherwise
     */
    public function add_menu_item($data)
    {
        return $this->db->insert('menu_items', $data);
    }

    /**
     * Update a menu item
     *
     * @param int $id Menu item ID
     * @param array $data Menu item data
     * @return bool True if successful, false otherwise
     */
    public function update_menu_item($id, $data)
    {
        $this->db->where('id_menu', $id);
        return $this->db->update('menu_items', $data);
    }

    /**
     * Delete a menu item
     *
     * @param int $id Menu item ID
     * @return bool True if successful, false otherwise
     */
    public function delete_menu_item($id)
    {
        $this->db->where('id_menu', $id);
        return $this->db->delete('menu_items');
    }
}