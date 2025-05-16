<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_berlangganan_model extends CI_Model {

    private $table = 'profile_berlangganan';

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    // Optional: For searching and filtering
    public function search($keyword) {
        $this->db->like('nama', $keyword);
        $this->db->or_like('profile', $keyword);
        $this->db->or_like('group_rate', $keyword);
        return $this->db->get($this->table)->result();
    }
}