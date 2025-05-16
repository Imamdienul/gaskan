<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['Spk_pelanggan_m', 'Project_m', 'Users_m', 'Jenis_pekerjaan_m', 'Log_m', 'Customers_m']);
    }


    public function spk_pelanggan()
    {
        $spk = $this->Spk_pelanggan_m;
        $project = $this->Project_m;
        $user = $this->Users_m;
        $jenis_pekerjaan = $this->Jenis_pekerjaan_m;
        $validation = $this->form_validation;
        $validation->set_rules($spk->rules_spk());
        if ($validation->run() == FALSE) {
            $data['user'] = $user->get_all_users();
            $data['project'] = $project->get_all_project();
            $data['jenis_pekerjaan'] = $jenis_pekerjaan->get_all_jenis_pekerjaan();
            $data['spk'] = $spk->get_all_spk_pelanggan();
            $data['customers'] = $this->Customers_m->get_all_customer();
            $this->template->load('shared/index', 'spk/spk_pelanggan', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $spk->add_spk_pelanggan($post);
            if ($this->db->affected_rows() > 0) {
                $this->Log_m->create_log('insert SPK NO ' . 'GSK/' . date('dmy') . '/CUS/' . sprintf("%04d", $spk->get_no_urut_spk()));
                $this->session->set_flashdata('success', 'Data SPK berhasil disimpan!');
                redirect('spk/spk_pelanggan', 'refresh');
            }
        }
    }
    public function edit_spk_pelanggan($id = null)
    {
        $spk = $this->Spk_pelanggan_m;
        $project = $this->Project_m;
        $user = $this->Users_m;
        $jenis_pekerjaan = $this->Jenis_pekerjaan_m;
        $validation = $this->form_validation;
        $validation->set_rules($spk->rules_spk());
        if ($validation->run() == FALSE) {
            $data['user'] = $user->get_all_users();
            $data['project'] = $project->get_all_project();
            $data['jenis_pekerjaan'] = $jenis_pekerjaan->get_all_jenis_pekerjaan();
            $data['spk'] = $spk->get_all_spk_pelanggan();
            $data['data'] = $spk->get_spk_pelanggan_by_id(decrypt_url($id));
            $data['customers'] = $this->Customers_m->get_all_customer();
            if ($data['data']) {
                $this->template->load('shared/index', 'spk/spk_pelanggan_edit', $data);
            } else {
                $this->session->set_flashdata('warning', 'Data spk pelanggan tidak ditemukan!');
                redirect('spk/spk_pelanggan', 'refresh');
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $spk->update_spk_pelanggan($id, $post);
            if ($this->db->affected_rows() > 0) {
                $data['data'] = $spk->get_spk_pelanggan_by_id(decrypt_url($id));
                $this->Log_m->create_log('update data spk pelanggan nomor ' . $data['data']->no_spk);
                $this->session->set_flashdata('success', 'Update data spk pelanggan berhasil!');
                redirect('spk/spk_pelanggan', 'refresh');
            } else {
                $this->session->set_flashdata('warning', 'Update data dibatalkan!');
                redirect('spk/spk_pelanggan', 'refresh');
            }
        }
    }
    public function delete_spk_pelanggan($id)
    {
        $this->Spk_pelanggan_m->delete_spk_pelanggan(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->Log_m->create_log('delete SPK pelanggan ID ' . decrypt_url($id));
            $this->session->set_flashdata('success', 'Data spk pelanggan berhasil dihapus!');
            redirect('spk/spk_pelanggan', 'refresh');
        }
    }
}

/* End of file Spk.php */
