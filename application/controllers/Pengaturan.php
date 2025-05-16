<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('Pengaturan_m');
        $this->load->model('Users_m');

    }


    public function ganti_pass()
    {
        $pengaturan = $this->Pengaturan_m;
        $validation = $this->form_validation;
        $validation->set_rules($pengaturan->rules_ganti_pass());
        if ($validation->run() == FALSE) {
            $this->template->load('shared/index', 'pengaturan/ganti_password');
        } else {
            $post = $this->input->post(null, TRUE);
            $user = $this->session->userdata('id_user');
            $data = $this->Users_m->cek_password_lama($user, $post['fpwd_lama']);
            //cek password lama
            if ($data) {
                $this->Users_m->ganti_password($user, $post['fpwd_baru']);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success', 'Password berhasil diganti.');
                    redirect('pengaturan/ganti_pass', 'refresh');
                }

            } else {
                $this->session->set_flashdata('error', 'Password lama tidak cocok!');
                redirect('pengaturan/ganti_pass', 'refresh');
            }
            // $this->template->load('shared/index', 'pengaturan/ganti_password');
        }


    }
    // public function whatsapp()
    // {
    //     $this->template->load('shared/index', 'pengaturan/whatsapp');

    // }

}

/* End of file Pengaturan.php */