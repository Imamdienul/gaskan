<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berlangganan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load models
        $this->load->model('berlangganan_model');
    }
    
    public function index() {
        $data['title'] = 'Manajemen PPPoE';
        $data['berlangganan'] = $this->berlangganan_model->get_all_berlangganan();
        $data['customers'] = $this->berlangganan_model->get_available_customers();
        $data['registrations'] = $this->berlangganan_model->get_available_registrations();
        
        $this->template->load('shared/index', 'berlangganan/index', $data);
    }
    
    public function add() {
        // Set validation rules
        $this->form_validation->set_rules('source_type', 'Sumber Data', 'required');
        $this->form_validation->set_rules('source_id', 'Sumber ID', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('ip_address', 'IP Address', 'required|callback_ip_check');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('berlangganan');
        } else {
            $source_type = $this->input->post('source_type');
            $source_id = $this->input->post('source_id');
            
            if (empty($source_id)) {
                $this->session->set_flashdata('error', 'Silakan pilih Customer atau Registrasi terlebih dahulu');
                redirect('berlangganan');
                return;
            }
            
            $data = [
                'id_customer' => NULL,
                'id_registrasi_customer' => NULL,
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'ip_address' => $this->input->post('ip_address')
            ];
            
            // Set the appropriate ID based on source type
            if ($source_type == 'customer') {
                $data['id_customer'] = $source_id;
            } else if ($source_type == 'registration') {
                $data['id_registrasi_customer'] = $source_id;
            } else {
                $this->session->set_flashdata('error', 'Tipe sumber data tidak valid');
                redirect('berlangganan');
                return;
            }
            
            if ($this->berlangganan_model->add_ppoe_user($data)) {
                $this->session->set_flashdata('success', 'PPPoE User berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan PPPoE User');
            }
            
            redirect('berlangganan');
        }
    }
    
    public function edit($id) {
        // Set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check['.$id.']');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('ip_address', 'IP Address', 'required|callback_ip_check['.$id.']');
        $this->form_validation->set_rules('status', 'Status', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('berlangganan');
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'ip_address' => $this->input->post('ip_address'),
                'status' => $this->input->post('status')
            ];
            
            if ($this->berlangganan_model->update_ppoe_user($id, $data)) {
                $this->session->set_flashdata('success', 'PPPoE User berhasil diupdate');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate PPPoE User');
            }
            
            redirect('berlangganan');
        }
    }
    
    // Rest of your controller methods remain unchanged
    public function delete($id) {
        if ($this->berlangganan_model->delete_ppoe_user($id)) {
            $this->session->set_flashdata('success', 'PPPoE User berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus PPPoE User');
        }
        
        redirect('berlangganan');
    }
    
    public function get_customer_data() {
        $id = $this->input->post('id');
        $customer = $this->berlangganan_model->get_customer($id);
        
        if ($customer) {
            // Generate username from id_customer + @gisaka.net
            $username = $customer->id_customer . '@gisaka.net';
            $password = $customer->id_customer;
            
            $data = [
                'username' => $username,
                'password' => $password,
                'name' => $customer->fullname,
                'ip_address' => $this->berlangganan_model->generate_next_ip()
            ];
            
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Customer not found']);
        }
    }
    
    public function get_registration_data() {
        $id = $this->input->post('id');
        $registration = $this->berlangganan_model->get_registration($id);
        
        if ($registration) {
         
            $username = $registration->nomor_registrasi . '@gisaka.net';
            $password = $registration->nomor_registrasi;
            
            $data = [
                'username' => $username,
                'password' => $password,
                'name' => $registration->nama_lengkap,
                'ip_address' => $this->berlangganan_model->generate_next_ip()
            ];
            
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Registration not found']);
        }
    }
    
    public function get_berlangganan_data() {
        $id = $this->input->post('id');
        $berlangganan = $this->berlangganan_model->get_berlangganan($id);
        
        if ($berlangganan) {
            echo json_encode($berlangganan);
        } else {
            echo json_encode(['error' => 'Subscription not found']);
        }
    }
    
    // Custom validation callback for username
    public function username_check($username, $id = '') {
        if ($this->berlangganan_model->check_username_exists($username, $id)) {
            $this->form_validation->set_message('username_check', 'Username sudah digunakan');
            return FALSE;
        }
        return TRUE;
    }
    
    // Custom validation callback for IP address
    public function ip_check($ip, $id = '') {
        if ($this->berlangganan_model->check_ip_exists($ip, $id)) {
            $this->form_validation->set_message('ip_check', 'IP Address sudah digunakan');
            return FALSE;
        }
        return TRUE;
    }
    public function get_status() {
    // Cek apakah request berupa AJAX
    if ($this->input->is_ajax_request()) {
        $id = $this->input->post('id');
        if ($id) {
            // Ambil status single user
            $berlangganan = $this->berlangganan_model->get_berlangganan($id);
            if ($berlangganan) {
                $status = $this->berlangganan_model->get_pppoe_status($berlangganan->username);
                echo json_encode(['status' => $status]);
            } else {
                echo json_encode(['error' => 'PPPoE user not found']);
            }
        } else {
            // Ambil status semua user
            $status = $this->berlangganan_model->get_all_pppoe_status();
            echo json_encode($status);
        }
    } else {
        show_404();
    }
}
}