<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_role_administrator_and_admin_officer();
        $this->load->model('Customers_m');
        $this->load->model('Registrasi_m');
        $this->load->model('Wilayah');
    }

    public function browse()
    {
        $data['customers'] = $this->Customers_m->get_all_customer();
        $this->template->load('shared/index', 'customer/index', $data);
    }
    public function create_from_registrasi()
{
    $data['registrasi_list'] = $this->Registrasi_m->get_all_data_registrasi();
    $this->template->load('shared/index', 'customer/create_from_registrasi', $data);
}

public function process_create_from_registrasi()
{
    $id_registrasi = $this->input->post('id_registrasi');
    
    if ($id_registrasi) {
        $result = $this->Customers_m->add_customer_from_registrasi($id_registrasi);
        
        if ($result > 0) {
            $this->session->set_flashdata('success', 'Data customer berhasil disimpan dari registrasi!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data customer!');
        }
    } else {
        $this->session->set_flashdata('error', 'Pilih data registrasi terlebih dahulu!');
    }
    
    redirect('customer/browse', 'refresh');
}

    public function browse_registrasi()
    {
        $data['customers'] = $this->Registrasi_m->get_all_data_registrasi();
        $this->template->load('shared/index', 'customer/registration', $data);
    }

    public function detail_registrasi($id = null)
    {
        include_once APPPATH . '/third_party/fpdf/fpdf.php';
        $data['data'] = $this->Registrasi_m->get_by_id_registrasi(decrypt_url($id));
        $this->load->view('customer/detail_registration', $data, FALSE);
    }

    public function onbill()
    {
        $data['customers'] = $this->Customers_m->get_all_customer();
        $this->template->load('shared/index', 'customer/onbill', $data);
    }

    public function create()
    {
        $customers = $this->Customers_m;
        $validation = $this->form_validation;
        $validation->set_rules($customers->rules());
        
        if ($validation->run() == FALSE) {
            $data['id_cust'] = $this->Customers_m->get_id_customer();
            $data['provinsi'] = $this->Wilayah->get_all_provinsi();
            $this->template->load('shared/index', 'customer/create', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $customers->add_customer($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data customer berhasil disimpan!');
                redirect('customer/create', 'refresh');
            }
        }
    }

    public function edit($id = null)
    {
        $customers = $this->Customers_m;
        $validation = $this->form_validation;
        $validation->set_rules($customers->rules());
        
        if ($validation->run() == FALSE) {
            $data['cust'] = $this->Customers_m->get_cust_by_id(decrypt_url($id));
            $data['provinsi'] = $this->Wilayah->get_all_provinsi();
            
            // Mengambil data wilayah untuk pilihan default
            $data['kabupaten'] = [];
            $data['kecamatan'] = [];
            $data['desa'] = [];
            
            $this->template->load('shared/index', 'customer/edit', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $customers->edit_customer($post, decrypt_url($id));
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data customer berhasil disimpan!');
                redirect('customer/browse', 'refresh');
            } else {
                $this->session->set_flashdata('warning', 'Batal edit data pelanggan');
                redirect('customer/browse', 'refresh');
            }
        }
    }
    
    public function delete($id)
    {
        $this->Customers_m->delete_customer(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pelanggan berhasil dihapus!');
            redirect('customer/browse', 'refresh');
        }
    }
    
    // Fungsi AJAX untuk mengambil data wilayah
    public function get_kabupaten()
    {
        $provinsi_id = $this->input->post('provinsi_id');
        $data = $this->Wilayah->get_kabupaten_by_provinsi($provinsi_id);
        echo json_encode($data);
    }
    
    public function get_kecamatan()
    {
        $kabupaten_id = $this->input->post('kabupaten_id');
        $data = $this->Wilayah->get_kecamatan_by_kabupaten($kabupaten_id);
        echo json_encode($data);
    }
    
    public function get_desa()
    {
        $kecamatan_id = $this->input->post('kecamatan_id');
        $data = $this->Wilayah->get_desa_by_kecamatan($kecamatan_id);
        echo json_encode($data);
    }
}