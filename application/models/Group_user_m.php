<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Group_user_m extends CI_Model
{
    private $_table = 'group_users';
    public $id_group_user;
    public $group_user;
    public $deleted;

    public function rules()
    {
        return [
            [
                'field' => 'fgroup_user',
                'label' => 'group user',
                'rules' => 'required|is_unique[group_users.group_user]'
            ],
        ];
    }

    public function get_all_group_user()
    {
        return $this->db->get_where($this->_table, ["deleted" => 0])->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->_table, ['id_group_user' => $id, 'deleted' => 0])->row();
    }

    public function add_group_user()
    {
        $post = $this->input->post();
        $this->group_user = $post['fgroup_user'];
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }

    public function update_group_user($id)
    {
        $post = $this->input->post();
        $this->group_user = $post['fgroup_user'];
        
        $this->db->where('id_group_user', $id);
        $this->db->update($this->_table, $this);
    }

    public function delete_group_user($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_group_user', $id);
        $this->db->update($this->_table);
    }

    public function check_group_name_exists($group_name, $id = null)
    {
        $this->db->where('group_user', $group_name);
        $this->db->where('deleted', 0);
        
        if ($id != null) {
            $this->db->where('id_group_user !=', $id);
        }
        
        return $this->db->get($this->_table)->num_rows() > 0;
    }

    public function get_group_user_with_menu_count()
    {
        $this->db->select('group_users.*, COUNT(menu_access.id_menu) as menu_count');
        $this->db->from($this->_table);
        $this->db->join('menu_access', 'menu_access.id_group_user = group_users.id_group_user', 'left');
        $this->db->where('group_users.deleted', 0);
        $this->db->group_by('group_users.id_group_user');
        
        return $this->db->get()->result();
    }
}
/* End of file Group_user_m.php */