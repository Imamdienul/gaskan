<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_role_administrator();
        $this->load->model('Wilayah_m');

    }


    public function index()
    {
        $wilayah = $this->Wilayah_m;
        $validation = $this->form_validation;
        $validation->set_rules($wilayah->rules());
        if ($validation->run() == FALSE) {
            $data['wilayah'] = $this->Wilayah_m->get_all_wilayah();
            $this->template->load('shared/index', 'wilayah/index', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $wilayah->add_wilayah($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data wilayah berhasil disimpan!');
                redirect('wilayah', 'refresh');
            }
        }
    }
    public function delete($id)
    {
        $this->Wilayah_m->delete_wilayah(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data wilayah berhasil dihapus!');
            redirect('wilayah', 'refresh');
        }
    }

}

/* End of file Wilayah.php */