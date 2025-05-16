<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Odp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_not_login();
        
        $this->load->model('Odp_model', 'odp');
        $this->load->library('form_validation');
    }
    
    public function index() {
        $data['title'] = 'Manajemen ODP';
        $data['odps'] = $this->odp->get_all();
        
        $this->template->load('shared/index', 'odp/index', $data);
    }
    
    public function add() {
        $data['title'] = 'Tambah ODP Baru';
        $data['wilayah'] = $this->odp->get_wilayah();
        
        $this->form_validation->set_rules('nama_odp', 'Nama ODP', 'required|trim');
        $this->form_validation->set_rules('kapasitas', 'Kapasitas', 'required|numeric');
        $this->form_validation->set_rules('terpakai', 'Terpakai', 'required|numeric');
        $this->form_validation->set_rules('id_wilayah', 'Wilayah', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->template->load('shared/index', 'odp/form', $data);
        } else {
            $data = [
                'nama_odp' => $this->input->post('nama_odp'),
                'kapasitas' => $this->input->post('kapasitas'),
                'terpakai' => $this->input->post('terpakai'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'id_wilayah' => $this->input->post('id_wilayah'),
                'alamat' => $this->input->post('alamat')
            ];
            
            $insert_id = $this->odp->insert($data);
            
            if ($insert_id) {
                $this->session->set_flashdata('success', 'ODP berhasil ditambahkan!');
                redirect('odp');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat menambahkan ODP!');
                redirect('odp/add');
            }
        }
    }
    
    public function edit($id) {
        $data['title'] = 'Edit ODP';
        $data['odp'] = $this->odp->get_by_id($id);
        $data['wilayah'] = $this->odp->get_wilayah();
        
        if (!$data['odp']) {
            $this->session->set_flashdata('error', 'ODP tidak ditemukan!');
            redirect('odp');
        }
        
        $this->form_validation->set_rules('nama_odp', 'Nama ODP', 'required|trim');
        $this->form_validation->set_rules('kapasitas', 'Kapasitas', 'required|numeric');
        $this->form_validation->set_rules('terpakai', 'Terpakai', 'required|numeric');
        $this->form_validation->set_rules('id_wilayah', 'Wilayah', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->template->load('shared/index', 'odp/form', $data);
        } else {
            $data = [
                'nama_odp' => $this->input->post('nama_odp'),
                'kapasitas' => $this->input->post('kapasitas'),
                'terpakai' => $this->input->post('terpakai'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'id_wilayah' => $this->input->post('id_wilayah'),
                'alamat' => $this->input->post('alamat')
            ];
            
            $update = $this->odp->update($id, $data);
            
            if ($update) {
                $this->session->set_flashdata('success', 'ODP berhasil diperbarui!');
                redirect('odp');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat memperbarui ODP!');
                redirect('odp/edit/' . $id);
            }
        }
    }
    
    public function detail($id) {
        $data['title'] = 'Detail ODP';
        $data['odp'] = $this->odp->get_by_id($id);
        
        if (!$data['odp']) {
            $this->session->set_flashdata('error', 'ODP tidak ditemukan!');
            redirect('odp');
        }
        
        $this->template->load('shared/index', 'odp/detail', $data);
    }
    
    public function delete($id) {
        $odp = $this->odp->get_by_id($id);
        
        if (!$odp) {
            $this->session->set_flashdata('error', 'ODP tidak ditemukan!');
            redirect('odp');
        }
        
        $delete = $this->odp->delete($id);
        
        if ($delete) {
            $this->session->set_flashdata('success', 'ODP berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat menghapus ODP!');
        }
        
        redirect('odp');
    }
}