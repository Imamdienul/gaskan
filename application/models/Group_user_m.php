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
    public function add_group_user()
    {
        $post = $this->input->post();
        $this->group_user = $post['fgroup_user'];
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    public function delete_group_user($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_group_user', $id);
        $this->db->update($this->_table);
    }


}

/* End of file Group_user_m.php */