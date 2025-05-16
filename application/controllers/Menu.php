<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_role_administrator(); // Only administrators can manage menus
        $this->load->model('Menu_model');
        $this->load->model('Group_user_m');
    }

    /**
     * Display list of all menu items
     */
    public function index()
    {
        $data['menu_items'] = $this->Menu_model->get_all_menu_items();
        $this->template->load('shared/index', 'menu/index', $data);
    }

    /**
     * Form to add a new menu item
     */
    public function add()
    {
        $validation = $this->form_validation;
        $validation->set_rules('menu_name', 'Menu Name', 'required');
        $validation->set_rules('menu_url', 'Menu URL', 'required');
        $validation->set_rules('menu_icon', 'Menu Icon', 'required');
        
        if ($validation->run() == FALSE) {
            $data['parent_menus'] = $this->Menu_model->get_parent_menu_items();
            $this->template->load('shared/index', 'menu/add', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $data = [
                'menu_name' => $post['menu_name'],
                'menu_url' => $post['menu_url'],
                'menu_icon' => $post['menu_icon'],
                'parent_id' => $post['parent_id'] == '' ? NULL : $post['parent_id'],
                'menu_order' => $post['menu_order'],
                'is_parent' => $post['is_parent']
            ];
            
            $this->Menu_model->add_menu_item($data);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Menu item added successfully!');
            }
            redirect('menu', 'refresh');
        }
    }

    /**
     * Form to edit a menu item
     */
    public function edit($id)
    {
        $validation = $this->form_validation;
        $validation->set_rules('menu_name', 'Menu Name', 'required');
        $validation->set_rules('menu_url', 'Menu URL', 'required');
        $validation->set_rules('menu_icon', 'Menu Icon', 'required');
        
        if ($validation->run() == FALSE) {
            $data['menu_item'] = $this->db->get_where('menu_items', ['id_menu' => $id])->row();
            $data['parent_menus'] = $this->Menu_model->get_parent_menu_items();
            $this->template->load('shared/index', 'menu/edit', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $data = [
                'menu_name' => $post['menu_name'],
                'menu_url' => $post['menu_url'],
                'menu_icon' => $post['menu_icon'],
                'parent_id' => $post['parent_id'] == '' ? NULL : $post['parent_id'],
                'menu_order' => $post['menu_order'],
                'is_parent' => $post['is_parent']
            ];
            
            $this->Menu_model->update_menu_item($id, $data);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Menu item updated successfully!');
            }
            redirect('menu', 'refresh');
        }
    }

    /**
     * Delete a menu item
     */
    public function delete($id)
    {
        $this->Menu_model->delete_menu_item($id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Menu item deleted successfully!');
        }
        redirect('menu', 'refresh');
    }

    /**
     * Manage menu access for user groups
     */
    public function access($group_id = null)
    {
        if ($group_id == null) {
            $data['user_groups'] = $this->Group_user_m->get_all_group_user();
            $this->template->load('shared/index', 'menu/access_groups', $data);
        } else {
            if ($this->input->post()) {
                $menu_ids = $this->input->post('menu');
                
                // Clear all existing access for this group
                $this->db->where('id_group_user', $group_id);
                $this->db->delete('menu_access');
                
                // Add new access permissions
                if (!empty($menu_ids)) {
                    foreach ($menu_ids as $menu_id) {
                        $this->Menu_model->add_access($group_id, $menu_id);
                    }
                }
                
                $this->session->set_flashdata('success', 'Menu access updated successfully!');
                redirect('menu/access', 'refresh');
            }
            
            $data['group'] = $this->Group_user_m->get_by_id($group_id);
            $data['menu_items'] = $this->Menu_model->get_menu_access_by_group($group_id);
            $this->template->load('shared/index', 'menu/access_edit', $data);
        }
    }
}