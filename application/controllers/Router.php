<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Router extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model
        $this->load->model('Model_Router');
        // Load library
        $this->load->library('template');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('download');
    }

    public function index() {
        $data['title'] = 'Manajemen Router Mikrotik';
        $routers = $this->Model_Router->get_all_routers();
        
        // Tambahkan info username, password, dan status ke setiap router
        foreach ($routers as &$router) {
            $description_parts = $this->Model_Router->parse_router_description($router->description);
            $router->username = $description_parts['username'];
            $router->password = $description_parts['password'];
            $router->status = $description_parts['status'];
        }
        
        $data['routers'] = $routers;
        
        // Load view
        $this->template->load('shared/index', 'router/index', $data);
    }

    public function add() {
        $data['title'] = 'Tambah Router Mikrotik';
        
        // Set validation rules
        $this->form_validation->set_rules('nama', 'Nama Router', 'required');
        $this->form_validation->set_rules('ip_address', 'IP Address', 'required|valid_ip');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('port', 'Port', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->template->load('shared/index', 'router/add', $data);
        } else {
            $router_data = array(
                'nama' => $this->input->post('nama'),
                'ip_address' => $this->input->post('ip_address'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'port' => $this->input->post('port'),
                'status' => 'disconnected',
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $router_id = $this->Model_Router->add_router($router_data);
            
            if ($router_id) {
                $this->session->set_flashdata('success', 'Router berhasil ditambahkan!');
                redirect('router');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan router!');
                $this->template->load('shared/index', 'router/add', $data);
            }
        }
    }

    public function edit($id) {
        $data['title'] = 'Edit Router Mikrotik';
        $router = $this->Model_Router->get_router_by_id($id);
        
        if (empty($router)) {
            $this->session->set_flashdata('error', 'Router tidak ditemukan!');
            redirect('router');
        }
        
        // Parse informasi dari description
        $description_parts = $this->Model_Router->parse_router_description($router->description);
        
        // Gabungkan data router dengan informasi dari description
        $data['router'] = (object) array_merge(
            (array) $router,
            [
                'username' => $description_parts['username'],
                'password' => $description_parts['password'],
                'status' => $description_parts['status']
            ]
        );
        
        // Set validation rules
        $this->form_validation->set_rules('nama', 'Nama Router', 'required');
        $this->form_validation->set_rules('ip_address', 'IP Address', 'required|valid_ip');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('port', 'Port', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->template->load('shared/index', 'router/edit', $data);
        } else {
            $router_data = array(
                'nama' => $this->input->post('nama'),
                'ip_address' => $this->input->post('ip_address'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'port' => $this->input->post('port'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $update = $this->Model_Router->update_router($id, $router_data);
            
            if ($update) {
                $this->session->set_flashdata('success', 'Router berhasil diperbarui!');
                redirect('router');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui router!');
                $this->template->load('shared/index', 'router/edit', $data);
            }
        }
    }

    public function delete($id) {
        $delete = $this->Model_Router->delete_router($id);
        
        if ($delete) {
            $this->session->set_flashdata('success', 'Router berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus router!');
        }
        
        redirect('router');
    }

    public function check_connection($id) {
        $router = $this->Model_Router->get_router_by_id($id);
        
        if (empty($router)) {
            $this->session->set_flashdata('error', 'Router tidak ditemukan!');
            redirect('router');
        }
        
        // Check connection using SNMP
        $status = $this->check_snmp_connection($router->nasname);
        
        // Parse informasi dari description
        $description_parts = $this->Model_Router->parse_router_description($router->description);
        
        // Update router status
        $this->Model_Router->update_router($id, array(
            'username' => $description_parts['username'],
            'password' => $description_parts['password'],
            'status' => $status
        ));
        
        $this->session->set_flashdata('success', 'Status koneksi router diperbarui!');
        redirect('router');
    }
    
    private function check_snmp_connection($ip_address) {
        // SNMP settings
        $community = 'public';
        $oid = '1.3.6.1.2.1.1.1.0'; // System description
        $timeout = 1000000; // 1 second
        $retries = 3;
        
        // Try to get SNMP data
        $snmp_data = @snmp2_get($ip_address, $community, $oid, $timeout, $retries);
        
        if ($snmp_data !== false) {
            return 'connected';
        } else {
            return 'disconnected';
        }
    }
    
    public function download_script($id) {
        $router = $this->Model_Router->get_router_by_id($id);
        
        if (empty($router)) {
            $this->session->set_flashdata('error', 'Router tidak ditemukan!');
            redirect('router');
        }
        
        // Parse informasi dari description
        $description_parts = $this->Model_Router->parse_router_description($router->description);
        
        // Gabungkan data router dengan informasi dari description
        $router_info = (object) array_merge(
            (array) $router,
            [
                'username' => $description_parts['username'],
                'password' => $description_parts['password'],
                'status' => $description_parts['status']
            ]
        );
        
        // Get server IP for RADIUS
        $server_ip = $_SERVER['SERVER_ADDR'];
        
        // Generate script content
        $script_content = $this->generate_mikrotik_script($router_info, $server_ip);
        
        // Download file
        $filename = 'radius_setup_' . $router->shortname . '.rsc';
        force_download($filename, $script_content);
    }
    
    private function generate_mikrotik_script($router, $server_ip) {
        // Create the script for Mikrotik to connect to RADIUS server
        $script = "# Script konfigurasi RADIUS untuk router " . $router->nama . "\n";
        $script .= "# Dibuat pada " . date('Y-m-d H:i:s') . "\n\n";
        $script .= "/radius add address=" . $server_ip . " secret=rahasia service=ppp,hotspot,dhcp,wireless\n";
        $script .= "/radius add address=" . $server_ip . " secret=rahasia service=login\n\n";
        $script .= "/ip firewall filter add chain=forward action=add-src-to-address-list address-list=active-users\n";
        $script .= "/ip firewall address-list add list=active-users\n\n";
        $script .= "/snmp set enabled=yes contact=admin@example.com location=\"Data Center\" trap-community=public trap-version=2\n";
        $script .= "/snmp community set [ find default=yes ] name=public\n\n";
        $script .= "/ppp aaa set use-radius=yes accounting=yes interim-update=5m\n";
        $script .= "/radius incoming set accept=yes\n\n";
        $script .= "# Konfigurasi RADIUS selesai\n";
        
        return $script;
    }
}