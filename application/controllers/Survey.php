<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Survey extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('Survey_m');
        $this->load->model('Registrasi_m');
        //$this->load->library('Excel');
    }
    
    public function index()
    {
        check_role_administrator_and_admin_officer();
        $data['customers'] = $this->Survey_m->get_unsurveyed_customers();
        $data['teknisi'] = $this->Survey_m->get_all_teknisi();
        $this->template->load('shared/index', 'survey/index', $data);
    }
    
    public function assign_survey()
    {
        check_role_administrator_and_admin_officer();
        
        $post = $this->input->post(null, TRUE);
        
        // Check if this is an update
        if (isset($post['is_update']) && $post['is_update'] == 1) {
            $this->Survey_m->update_survey_assignment($post);
            
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Penugasan survey berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('error', 'Tidak ada perubahan pada penugasan survey!');
            }
        } else {
            // New assignment
            $this->Survey_m->assign_survey($post);
            
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Tugas survey berhasil diberikan kepada teknisi!');
            } else {
                $this->session->set_flashdata('error', 'Gagal memberikan tugas survey!');
            }
        }
        
        redirect('survey');
    }
    
    // New method for bulk assignment
    public function bulk_assign_survey()
    {
        check_role_administrator_and_admin_officer();
        
        $post = $this->input->post(null, TRUE);
        $customer_ids = explode(',', $post['customer_ids']);
        $success_count = 0;
        
        foreach ($customer_ids as $customer_id) {
            $assignment_data = [
                'id_registrasi_customer' => $customer_id,
                'id_teknisi' => $post['id_teknisi'],
                'catatan' => $post['catatan']
            ];
            
            $this->Survey_m->assign_survey($assignment_data);
            
            if ($this->db->affected_rows() > 0) {
                $success_count++;
            }
        }
        
        if ($success_count > 0) {
            $this->session->set_flashdata('success', "$success_count tugas survey berhasil diberikan kepada teknisi!");
        } else {
            $this->session->set_flashdata('error', 'Gagal memberikan tugas survey!');
        }
        
        redirect('survey');
    }
    
    // Export to Excel
    public function export_excel()
    {
        check_role_administrator_and_admin_officer();
        
        // Get filter parameters
        $status = $this->input->get('status');
        $layanan = $this->input->get('layanan');
        $kecamatan = $this->input->get('kecamatan');
        $bandwidth = $this->input->get('bandwidth');
        $teknisi = $this->input->get('teknisi');
        $search = $this->input->get('search');
        
        // Get filtered data
        $data = $this->Survey_m->get_filtered_customers($status, $layanan, $kecamatan, $bandwidth, $teknisi, $search);
        
        // Load Excel library
        $this->load->library('Excel');
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set column headers
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nomor Registrasi');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'Jenis Layanan');
        $sheet->setCellValue('E1', 'Bandwidth');
        $sheet->setCellValue('F1', 'Alamat Pemasangan');
        $sheet->setCellValue('G1', 'Status Survey');
        $sheet->setCellValue('H1', 'Teknisi');
        
        // Set data
        $no = 1;
        $row = 2;
        foreach ($data as $customer) {
            $assignment = $this->Survey_m->get_survey_assignment($customer->id_registrasi_customer);
            $teknisi_name = !empty($assignment) ? $assignment->nama_teknisi : '-';
            
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $customer->nomor_registrasi);
            $sheet->setCellValue('C' . $row, $customer->nama_lengkap);
            $sheet->setCellValue('D' . $row, $customer->jenis_layanan);
            $sheet->setCellValue('E' . $row, $customer->bandwidth);
            $sheet->setCellValue('F' . $row, $customer->alamat_pemasangan . ', ' . $customer->desa . ', ' . $customer->kecamatan);
            $sheet->setCellValue('G' . $row, $customer->status_survey);
            $sheet->setCellValue('H' . $row, $teknisi_name);
            
            $row++;
        }
        
        // Set column width
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(40);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);
        
        // Create filename and set headers
        $filename = 'Laporan_Survey_' . date('YmdHis') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
    
    public function teknisi_list()
    {
        
        
        $teknisi_id = $this->session->userdata('id_user');
        $data['assignments'] = $this->Survey_m->get_technician_assignments($teknisi_id);
        $this->template->load('shared/index', 'survey/teknisi_list', $data);
    }
    
    public function form_survey($id = null)
    {
        
        
        if ($id == null) {
            redirect('survey/teknisi_list');
        }
        
        $survey_task = $this->Survey_m->get_survey_task_by_id(decrypt_url($id));
        
        if (!$survey_task) {
            $this->session->set_flashdata('error', 'Data tugas survey tidak ditemukan!');
            redirect('survey/teknisi_list');
        }
        
        $data['survey_task'] = $survey_task;
        $data['odp_list'] = $this->Survey_m->get_all_odp();
        $this->template->load('shared/index', 'survey/form_survey', $data);
    }
    
    public function edit_survey($id = null)
    {
        // Check either admin or teknisi access
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }
        
        $customer_id = decrypt_url($id);
        $customer = $this->Registrasi_m->get_by_id_registrasi($customer_id);
        $survey_data = $this->Survey_m->get_survey_data_by_customer_id($customer_id);
        
        if (!$customer || !$survey_data) {
            $this->session->set_flashdata('error', 'Data survey tidak ditemukan!');
            redirect('survey/browse_survey');
        }
        
        $data['customer'] = $customer;
        $data['survey'] = $survey_data;
        $data['odp_list'] = $this->Survey_m->get_all_odp();
        $this->template->load('shared/index', 'survey/edit_survey', $data);
    }

    public function update_survey()
    {
        // Check either admin or teknisi access
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }
        
        $post = $this->input->post(null, TRUE);
        $update_result = $this->Survey_m->update_survey_result($post);
        
        if ($update_result) {
            $this->session->set_flashdata('success', 'Data hasil survey berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data hasil survey!');
        }
        
        redirect('survey/detail_survey/' . encrypt_url($post['id_registrasi_customer']));
    }
    
    public function save_survey()
    {
        
        
        $post = $this->input->post(null, TRUE);
        $this->Survey_m->save_survey_result($post);
        
        if ($this->db->affected_rows() > 0) {
            // If using ODP, update usage
            if (!empty($post['id_odp'])) {
                $this->Survey_m->update_odp_usage($post['id_odp']);
            }
            $teknisi_id = $this->session->userdata('id_user');
            $this->session->set_flashdata('success', 'Data hasil survey berhasil disimpan!');
            redirect('survey/teknisi_list');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data hasil survey!');
            redirect('survey/form_survey/' . encrypt_url($post['id_survey_teknisi']));
        }
    }
    
    public function browse_survey()
    {
        check_role_administrator_and_admin_officer();
        
        $data['customers'] = $this->Survey_m->get_surveyed_customers();
        $this->template->load('shared/index', 'survey/browse_survey', $data);
    }
    
    public function detail_survey($id = null)
    {
        if ($id == null) {
            redirect('survey/browse_survey');
        }
        
        $customer = $this->Registrasi_m->get_by_id_registrasi(decrypt_url($id));
        $survey_data = $this->Survey_m->get_survey_data_by_customer_id(decrypt_url($id));
        
        if (!$customer || !$survey_data) {
            $this->session->set_flashdata('error', 'Data survey tidak ditemukan!');
            redirect('survey/browse_survey');
        }
        
        $data['customer'] = $customer;
        $data['survey'] = $survey_data;
        $this->template->load('shared/index', 'survey/detail_survey', $data);
    }
    
    // ODP Management
    public function manage_odp()
    {
        check_role_administrator_and_admin_officer();
        
        $data['odp_list'] = $this->Survey_m->get_all_odp();
        $data['wilayah'] = $this->db->get('wilayah')->result();
        $this->template->load('shared/index', 'survey/manage_odp', $data);
    }
    
    public function add_odp()
    {
        check_role_administrator_and_admin_officer();
        
        $post = $this->input->post(null, TRUE);
        $this->Survey_m->add_odp($post);
        
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data ODP berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan data ODP!');
        }
        
        redirect('survey/manage_odp');
    }
}