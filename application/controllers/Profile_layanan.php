<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_layanan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_role_administrator();
        $this->load->model('Profile_layanan_m');


    }
    public function index()
    {
        $profile = $this->Profile_layanan_m;
        $validation = $this->form_validation;
        $validation->set_rules($profile->rules());
        if ($validation->run() == FALSE) {
            $data['profile'] = $this->Profile_layanan_m->get_all_profile();
            $this->template->load('shared/index', 'profile_layanan/index', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $profile->add_profile_layanan($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data profile layanan berhasil disimpan!');
                redirect('profile_layanan', 'refresh');
            }
        }
    }
    public function delete($id)
    {
        $this->Profile_layanan_m->delete_profile_layanan(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data profile layanan berhasil dihapus!');
            redirect('profile_layanan', 'refresh');
        }
    }
    public function set_status($id, $val)
    {
        $this->Profile_layanan_m->set_is_aktif(decrypt_url($id), $val);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data profile layanan berhasil diupdate!');
            redirect('profile_layanan', 'refresh');
        }
    }

}

/* End of file Profile_layanan.php */