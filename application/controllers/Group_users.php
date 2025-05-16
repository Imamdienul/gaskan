<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Group_users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['Group_user_m', 'Log_m']);
    }

    public function index()
    {
        $group_user = $this->Group_user_m;
        $validation = $this->form_validation;
        $validation->set_rules($group_user->rules());
        if ($validation->run() == FALSE) {
            $data['group_user'] = $this->Group_user_m->get_all_group_user();
            $this->template->load('shared/index', 'group_user/index', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $group_user->add_group_user($post);
            if ($this->db->affected_rows() > 0) {
                $this->Log_m->create_log('insert group user ' . $post['fgroup_user']);
                $this->session->set_flashdata('success', 'Data group user berhasil disimpan!');
                redirect('group_users', 'refresh');
            }
        }
    }
    public function delete($id)
    {
        $this->Group_user_m->delete_group_user(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->Log_m->create_log('delete group user id ' . decrypt_url($id));
            $this->session->set_flashdata('success', 'Data group user berhasil dihapus!');
            redirect('group_users', 'refresh');
        }
    }
}

/* End of file Group_user.php */