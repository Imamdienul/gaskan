<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Odp_model extends CI_Model {

    private $table = 'odp';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all() {
        $this->db->where('deleted', 0);
        return $this->db->get($this->table)->result();
    }
    
    public function get_by_id($id) {
        $this->db->where('id_odp', $id);
        $this->db->where('deleted', 0);
        return $this->db->get($this->table)->row();
    }
    
    public function insert($data) {
        $data['created_by'] = $this->session->userdata('id_user');
        $data['created_date'] = date('Y-m-d H:i:s');
        $data['deleted'] = 0;
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($id, $data) {
        $this->db->where('id_odp', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete($id) {
        $data['deleted'] = 1;
        $this->db->where('id_odp', $id);
        return $this->db->update($this->table, $data);
    }
    
    // Mendapatkan data wilayah untuk dropdown
    public function get_wilayah() {
        $this->db->where('deleted', 0);
        return $this->db->get('wilayah')->result();
    }
    
    // Method untuk menghitung jumlah ODP
    public function count_all() {
        $this->db->where('deleted', 0);
        return $this->db->count_all_results($this->table);
    }
}