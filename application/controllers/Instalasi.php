<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instalasi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();

        check_not_login();

        $this->load->model('Instalasi_m');
        $this->load->model('Registrasi_m');
        $this->load->model('Survey_m'); 
    }
    
    public function index()
    {
        check_role_administrator_and_admin_officer();

        $data['customers'] = $this->Instalasi_m->get_unsurveyed_customers();
        $data['teknisi'] = $this->Instalasi_m->get_all_teknisi();

        $this->template->load('shared/index', 'instalasi/index', $data);
    }
    
    public function assign_activation()
    {
        check_role_administrator_and_admin_officer();
        
        $post = $this->input->post(null, TRUE);
        
        // Check if this is an update
        if (isset($post['is_update']) && $post['is_update'] == 1) {
            $this->Instalasi_m->update_activation_assignment($post);
            
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Penugasan Instalasi berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('error', 'Tidak ada perubahan pada penugasan Instalasi!');
            }
        } else {
            // New assignment
            $this->Instalasi_m->assign_activation($post);
            
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Tugas Instalasi berhasil diberikan kepada teknisi!');
            } else {
                $this->session->set_flashdata('error', 'Gagal memberikan tugas Instalasi!');
            }
        }
        
        redirect('instalasi');
    }
    
    //function list Instalasi untuk role teknisi
    public function teknisi_list()
    {
        $teknisi_id = $this->session->userdata('id_user');
        $data['assignments'] = $this->Instalasi_m->get_technician_assignments($teknisi_id);
        $this->template->load('shared/index', 'instalasi/teknisi_list', $data);
    }
    
    //function inisiasi data pengisian form Instalasi
    public function form_Instalasi($id = null)
    {
        
        
        if ($id == null) {
            redirect('instalasi/teknisi_list');
        }

        $activation_task = $this->Instalasi_m->get_activation_task_by_id(decrypt_url($id));
        
        if (!$activation_task) {
            $this->session->set_flashdata('error', 'Data tugas Instalasi tidak ditemukan!');
            redirect('instalasi/teknisi_list');
        }

        $teknisi_id = $this->session->userdata('id_user');
        $area = $this->Instalasi_m->get_all_area();
        $paket = $this->Instalasi_m->get_all_paket();

        $data['activation_task'] = $activation_task;
        $data['area'] = $area;
        $data['paket'] = $paket;
        $data['odp_list'] = $this->Instalasi_m->get_all_odp();

        $this->template->load('shared/index', 'instalasi/form_instalasi', $data);
    }

    public function edit_Instalasi($id) {
        $data['title'] = 'Edit Instalasi & Instalasi';
        $data['Instalasi'] = $this->Instalasi_m->get_activation_data_by_customer_id(decrypt_url($id));
        $data['area'] = $this->Instalasi_m->get_all_area();
        $data['paket'] = $this->Instalasi_m->get_all_paket();
        $data['customer'] = $this->Instalasi_m->get_all_customer();
        
        if (!$data['Instalasi']) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
            redirect('instalasi/teknisi_list');
        }
        
        $this->template->load('shared/index', 'instalasi/edit_instalasi', $data);
    }
    
    public function detail_Instalasi($id = null)
    {
        if ($id == null) {
            redirect('instalasi/browse_Instalasi');
        }

        $customer = $this->Registrasi_m->get_by_id_registrasi(decrypt_url($id));
        $Instalasi_data = $this->Instalasi_m->get_activation_data_by_customer_id(decrypt_url($id));
        
        // print_r(decrypt_url($id));
        // print_r($Instalasi_data);
        // return;
        
        if (!$customer || !$Instalasi_data) {
            $this->session->set_flashdata('error', 'Data Instalasi tidak ditemukan!');
            redirect('instalasi/browse_Instalasi');
        }
        
        $data['customer'] = $customer;
        $data['Instalasi'] = $Instalasi_data;
        

        $this->template->load('shared/index', 'instalasi/detail_instalasi', $data);
    }
    
    //function inisiasi data pengisian form Instalasi
    public function get_data_pelanggan()
    {
        $data_pelanggan = $this->Instalasi_m->get_data_customer($this->input->post('id_pelanggan'));
        echo json_encode($data_pelanggan);
    }
    
// In Instalasi.php controller
public function store() {
    $this->form_validation->set_rules('ftgl_pmsngn', 'Tanggal Pemasangan', 'required');
    $this->form_validation->set_rules('fjam_pmsngn', 'Waktu Pemasangan', 'required');
    $this->form_validation->set_rules('id_area', 'Area', 'required');
    $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'required');
    $this->form_validation->set_rules('id_paket', 'Paket', 'required');
    $this->form_validation->set_rules('odp', 'ODP', 'required');
    $this->form_validation->set_rules('port_odp', 'Port ODP', 'required');
    $this->form_validation->set_rules('pjg_kabel', 'Panjang Kabel', 'required|numeric');
    $this->form_validation->set_rules('no_roll_kabel', 'Nomor Roll Kabel', 'required');
    $this->form_validation->set_rules('merk_modem', 'Merk Modem', 'required');
    $this->form_validation->set_rules('tipe_modem', 'Tipe Modem', 'required');
    $this->form_validation->set_rules('sn_modem', 'SN Modem', 'required');
    $this->form_validation->set_rules('mac_modem', 'MAC Address', 'required');
    $this->form_validation->set_rules('redaman_plnggn', 'Redaman Pelanggan', 'required');
    
    $data = [
        'id_teknisi' => $this->input->post('id_teknisi'),
        'tgl_pasang' => $this->input->post('ftgl_pmsngn'),
        'waktu_pasang' => $this->input->post('fjam_pmsngn'),
        'id_area' => $this->input->post('id_area'),
        'id_registrasi_customer' => $this->input->post('id_registrasi_customer'),
        'id_paket' => $this->input->post('id_paket'),
        'odp' => $this->input->post('odp'),
        'port_odp' => $this->input->post('port_odp'),
        'panjang_kabel' => $this->input->post('pjg_kabel'),
        'nomor_roll_kabel' => $this->input->post('no_roll_kabel'),
        'merk_modem' => $this->input->post('merk_modem'),
        'tipe_modem' => $this->input->post('tipe_modem'),
        'sn_modem' => $this->input->post('sn_modem'),
        'mac_address' => $this->input->post('mac_modem'),
        'redaman_pelanggan' => $this->input->post('redaman_plnggn'),
        'catatan' => $this->input->post('note'),
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => $this->session->userdata('id_user'),
        'deskripsi_foto_koneksi' => $this->input->post('deskripsi_foto_koneksi'),
        'deskripsi_foto_redaman' => $this->input->post('deskripsi_foto_redaman'),
        'deskripsi_foto_instalasi' => $this->input->post('deskripsi_foto_instalasi'),
        'deskripsi_foto_rumah' => $this->input->post('deskripsi_foto_rumah')
    ];
    
    // Simpan data Instalasi
    $result = $this->Instalasi_m->save_Instalasi($data);

    if ($this->db->affected_rows() > 0) {
        // If using ODP, update usage
        if (!empty($data['odp'])) {
            $this->Survey_m->update_odp_usage($data['odp']);
        }
        
        // Load email helper
        $this->load->helper('email');
        
        // Get complete activation data for email
        $activation_data = $this->Instalasi_m->get_activation_data_by_customer_id($data['id_registrasi_customer']);
        $customer_data = $this->Registrasi_m->get_by_id_registrasi($data['id_registrasi_customer']);
        
        // Send activation email
        send_activation_email($activation_data, $customer_data);
        
        $teknisi_id = $this->session->userdata('id_user');
        $this->session->set_flashdata('success', 'Data Instalasi & Instalasi berhasil disimpan!');
        redirect('instalasi/teknisi_list');
    } else {
        $this->session->set_flashdata('error', 'Gagal menyimpan data Instalasi & Instalasi!');
        redirect('instalasi/form_instalasi/' . encrypt_url($post['id_teknisi']));
    }
}

public function update_Instalasi() {
    // Initialize params for update
    $data = [
        'id_Instalasi' => $this->input->post('id_Instalasi'),
        'id_teknisi' => $this->input->post('id_teknisi'),
        'tgl_pasang' => $this->input->post('ftgl_pmsngn'),
        'waktu_pasang' => $this->input->post('fjam_pmsngn'),
        'id_area' => $this->input->post('id_area'),
        'id_pelanggan' => $this->input->post('id_pelanggan'),
        'id_paket' => $this->input->post('id_paket'),
        'id_odp' => $this->input->post('odp'),
        'port_odp' => $this->input->post('port_odp'),
        'panjang_kabel' => $this->input->post('pjg_kabel'),
        'nomor_roll_kabel' => $this->input->post('no_roll_kabel'),
        'merk_modem' => $this->input->post('merk_modem'),
        'tipe_modem' => $this->input->post('tipe_modem'),
        'sn_modem' => $this->input->post('sn_modem'),
        'mac_address' => $this->input->post('mac_modem'),
        'redaman_pelanggan' => $this->input->post('redaman_plnggn'),
        'catatan' => $this->input->post('note'),
        'deskripsi_foto_koneksi' => $this->input->post('deskripsi_foto_koneksi'),
        'deskripsi_foto_redaman' => $this->input->post('deskripsi_foto_redaman'),
        'deskripsi_foto_instalasi' => $this->input->post('deskripsi_foto_instalasi'),
        'deskripsi_foto_rumah' => $this->input->post('deskripsi_foto_rumah')
    ];
    
    // Ubah data Instalasi
    $update_result = $this->Instalasi_m->update_activation_result($data);

    if ($update_result) {
        // Load email helper
        $this->load->helper('email');
        
        // Get customer ID from activation data
        $customer_id = $this->Instalasi_m->get_customer_id($data['id_Instalasi']);
        
        // Get complete activation data for email
        $activation_data = $this->Instalasi_m->get_activation_data_by_customer_id($customer_id['id_registrasi_customer']);
        $customer_data = $this->Registrasi_m->get_by_id_registrasi($customer_id['id_registrasi_customer']);
        
        // Send activation email
        send_activation_email($activation_data, $customer_data);
        
        $this->session->set_flashdata('success', 'Data Instalasi & Instalasi berhasil diubah!');
    } else {
        $this->session->set_flashdata('error', 'Gagal memperbarui data!');
    }
    
    redirect('instalasi/teknisi_list');
}

    public function approve_Instalasi($id) {
        $result = $this->Instalasi_m->approve_Instalasi($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data Instalasi & Instalasi berhasil diaktifkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan data!');
        }
        
        redirect('instalasi/teknisi_list');
    }
    
    
    
    public function delete_Instalasi($id)
    {
        $this->Instalasi_m->delete_activation(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data Instalasi berhasil dihapus!');
            redirect('instalasi/teknisi_list', 'refresh');
        }
    }

    public function generate_pdf()
    {
        $this->load->library('pdf');

        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial','B',16);
        $this->pdf->Cell(40,10,'Hello from CodeIgniter with FPDF!');
        $this->pdf->Output('I', 'sample.pdf'); // 'I' = inline, 'D' = download
    }
    
    public function browse_Instalasi()
    {
        check_role_administrator_and_admin_officer();
        
        $data['customers'] = $this->Instalasi_m->get_activated_customers();
        $this->template->load('shared/index', 'instalasi/browse_instalasi', $data);
    }
}