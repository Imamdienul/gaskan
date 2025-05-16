<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payroll extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_role_administrator_and_admin_officer();
        $this->load->model(['Users_m', 'Payroll_m', 'Kasbon_m']);
        $this->load->helper(['Rupiah', 'directory']);
    }

    public function index()
    {
        check_role_administrator_and_admin_officer();
        $data['arsip'] = directory_map('./uploads/payslip/');
        $data['users'] = $this->Users_m->get_all_users_active();
        $this->template->load('shared/index', 'payroll/index', $data);
    }
    public function archive()
    {
        check_role_administrator_and_admin_officer();
        $data['arsip'] = directory_map('./uploads/payslip/');
        $this->template->load('shared/index', 'payroll/archive', $data);
    }
    public function set_benefit($id_user = null)
    {
        check_role_administrator_and_admin_officer();
        $payroll = $this->Payroll_m;
        $validation = $this->form_validation;
        $validation->set_rules($payroll->rules_set_benefit());
        if ($validation->run() == FALSE) {
            $data['user'] = $this->Users_m->get_by_id_user(decrypt_url($id_user));
            $data['benefit'] = $this->Payroll_m->get_benefit_by_id_user(decrypt_url($id_user));
            $this->template->load('shared/index', 'payroll/set_benefit', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $payroll->add_benefit($id_user, $post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Benefit berhasil ditambahkan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function delete_benefit($id)
    {
        check_role_administrator_and_admin_officer();
        $this->Payroll_m->delete_benefit(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data benefit berhasil dihapus!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function payslip()
    {
        check_role_administrator_and_admin_officer();
        $payroll = $this->Payroll_m;
        $validation = $this->form_validation;
        $validation->set_rules($payroll->rules_payslip());
        if ($validation->run() == FALSE) {
            $data['user'] = $this->Users_m->get_all_users();
            $data['benefit'] = null;
            $data['kasbon'] = null;
            $data['total_benefit'] = null;
            $data['total_kasbon'] = null;
            $data['selectedUser'] = null;
            $data['kasbon'] = null;
            $data['post'] = null;
            $this->template->load('shared/index', 'payroll/payslip', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $data['post'] = $post;
            $data['user'] = $this->Users_m->get_all_users();
            $data['benefit'] = $this->Payroll_m->get_benefit_by_id_user(decrypt_url($post['fkaryawan']));
            $data['kasbon'] = $this->Kasbon_m->get_kasbon_gaji_by_bulan_by_user($post['fbulan'], $post['ftahun'], decrypt_url($post['fkaryawan']));
            $data['total_benefit'] = $this->Payroll_m->get_total_benefit_by_id_user(decrypt_url($post['fkaryawan']));
            $data['total_kasbon'] = $this->Kasbon_m->get_total_kasbon_gaji_by_bulan_by_user($post['fbulan'], $post['ftahun'], decrypt_url($post['fkaryawan']));
            $data['selectedUser'] = $this->Users_m->get_by_id_user(decrypt_url($post['fkaryawan']));
            $this->template->load('shared/index', 'payroll/payslip', $data);
        }
    }
}

/* End of file Payroll.php */
