<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_pekerjaan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_role_administrator();
        $this->load->helper('rupiah');
        $this->load->model(['Jenis_pekerjaan_m']);
    }


    public function index()
    {
        $jenis_pekerjaan = $this->Jenis_pekerjaan_m;
        $validation = $this->form_validation;
        $validation->set_rules($jenis_pekerjaan->rules_jenis_pekerjaan());
        if ($validation->run() == FALSE) {
            $data['jenis_pekerjaan'] = $jenis_pekerjaan->get_all_jenis_pekerjaan();
            $this->template->load('shared/index', 'spk/jenis_pekerjaan', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $jenis_pekerjaan->add_jenis_pekerjaan($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data jenis pekerjaan berhasil disimpan!');
                redirect('jenis_pekerjaan', 'refresh');
            }
        }
    }
    public function delete_jenis_pekerjaan($id)
    {
        $this->Jenis_pekerjaan_m->delete_jenis_pekerjaan(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data jenis pekerjaan berhasil dihapus!');
            redirect('jenis_pekerjaan', 'refresh');
        }
    }
}

/* End of file Jenis_pekerjaan.php */
