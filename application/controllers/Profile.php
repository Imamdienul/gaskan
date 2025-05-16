<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Profile_berlangganan_model', 'profile');
        $this->load->library('form_validation');
    }

    public function index() {
        $data = [
            'title' => 'Profile Berlangganan',
            'profiles' => $this->profile->get_all()
        ];
        
        $this->template->load('shared/index', 'berlangganan/profile', $data);
    }

    public function get_profile_by_id() {
        $id = $this->input->post('id');
        $data = $this->profile->get_by_id($id);
        echo json_encode($data);
    }

    public function save() {
        $response = [];
        
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('profile', 'Profile', 'required');
        $this->form_validation->set_rules('group_rate', 'Group Rate', 'required');
        $this->form_validation->set_rules('limit_shared', 'Limit Shared', 'required');
        $this->form_validation->set_rules('aktif', 'Aktif', 'required');
        $this->form_validation->set_rules('hpp', 'HPP', 'required|numeric');
        $this->form_validation->set_rules('komisi', 'Komisi', 'required|numeric');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = false;
            $response['message'] = validation_errors();
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'profile' => $this->input->post('profile'),
                'group_rate' => $this->input->post('group_rate'),
                'limit_shared' => $this->input->post('limit_shared'),
                'aktif' => $this->input->post('aktif'),
                'hpp' => $this->input->post('hpp'),
                'komisi' => $this->input->post('komisi'),
                'harga' => $this->input->post('harga'),
                'user' => $this->input->post('user', true) ?? 0
            ];
            
            $id = $this->input->post('id');
            if (empty($id)) {
                // Create new record
                $save = $this->profile->insert($data);
                $response['message'] = 'Profile berhasil ditambahkan';
            } else {
                // Update existing record
                $save = $this->profile->update($id, $data);
                $response['message'] = 'Profile berhasil diupdate';
            }
            
            $response['status'] = $save ? true : false;
        }
        
        echo json_encode($response);
    }

    public function delete() {
        $id = $this->input->post('id');
        $delete = $this->profile->delete($id);
        
        $response = [
            'status' => $delete ? true : false,
            'message' => $delete ? 'Profile berhasil dihapus' : 'Gagal menghapus profile'
        ];
        
        echo json_encode($response);
    }
    
    // Optional: For importing data initially
    public function import_data() {
        // The data from your prompt
        $data = [
            [
                'nama' => 'SILVER_20M_MJT_NEW',
                'profile' => 'UPTO20MBPS_MJT_NEW',
                'group_rate' => '20M/20M 0/0 0/0 0/0 8 3M/3M',
                'limit_shared' => '130 Hari',
                'aktif' => '130 Hari',
                'hpp' => 120000,
                'komisi' => 80000,
                'harga' => 200000,
                'user' => 0
            ],
            [
                'nama' => 'GOLD_40M_KJN',
                'profile' => 'UPTO40MBPS_KJN',
                'group_rate' => '40M/40M 0/0 0/0 0/0 7 5M/5M',
                'limit_shared' => '130 Hari',
                'aktif' => '130 Hari',
                'hpp' => 0,
                'komisi' => 300000,
                'harga' => 300000,
                'user' => 0
            ],
            // Add the remaining data similarly
        ];
        
        foreach ($data as $item) {
            $this->profile->insert($item);
        }
        
        redirect('profile');
    }
}