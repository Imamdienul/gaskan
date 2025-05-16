<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Status_pembelian_m extends CI_Model
{

    private $_table = "status_pembelian";
    public $no_pembelian;
    public $id_user;
    public $status_pembelian;
    public $no_status;
    public $note_status_pembelian;


    public function add_status_created_pembelian()
    {
        $post = $this->input->post();
        $this->id_user = $this->session->userdata('id_user');
        $this->no_pembelian = $post['fno_pembelian'];
        $this->status_pembelian = 'created';
        $this->note_status_pembelian = 'document has created';
        $this->note_status_pembelian = 'document has created';
        $this->no_status = 0;
        $this->db->insert($this->_table, $this);
    }
    public function add_status_approved_pm_pembelian()
    {
        $post = $this->input->post();
        $this->id_user = $this->session->userdata('id_user');
        $this->no_pembelian = $post['fno_pembelian'];
        $this->status_pembelian = 'approvedprojectmanager';
        $this->no_status = 1;
        $this->note_status_pembelian = $post['fnote'];
        $this->db->insert($this->_table, $this);
    }
    public function add_status_approved_adm_pembelian()
    {
        $post = $this->input->post();
        $this->id_user = $this->session->userdata('id_user');
        $this->no_pembelian = $post['fno_pembelian'];
        $this->status_pembelian = 'approvedadministrator';
        $this->no_status = 2;
        $this->note_status_pembelian = $post['fnote'];
        $this->db->insert($this->_table, $this);
    }
    public function add_status_rejected_adm_pembelian()
    {
        $post = $this->input->post();
        $this->id_user = $this->session->userdata('id_user');
        $this->no_pembelian = $post['fno_pembelian'];
        $this->status_pembelian = 'rejectedadministrator';
        $this->no_status = 2;
        $this->note_status_pembelian = $post['fnote'];
        $this->db->insert($this->_table, $this);
    }
    public function add_status_rejected_pm_pembelian()
    {
        $post = $this->input->post();
        $this->id_user = $this->session->userdata('id_user');
        $this->no_pembelian = $post['fno_pembelian'];
        $this->status_pembelian = 'rejectedprojectmanager';
        $this->no_status = 1;
        $this->note_status_pembelian = $post['fnote'];
        $this->db->insert($this->_table, $this);
    }
    public function cek_status($no_pembelian, $no_status)
    {
        $this->db->select('*');
        $this->db->where('no_pembelian', $no_pembelian);
        $this->db->where('no_status', $no_status);
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row();
    }
    public function get_status_by_no_pembelian($no_pembelian)
    {
        $this->db->select('status_pembelian.*, users.nama_user');
        $this->db->where('no_pembelian', $no_pembelian);
        $this->db->join('users', 'users.id_user = status_pembelian.id_user', 'left');
        $this->db->order_by('id_status_pembelian', 'desc');
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->result();
    }
    function cek_status_terkahir($no_pembelian)
    {
        $this->db->select('status_pembelian');
        $this->db->where('no_pembelian', $no_pembelian);
        $this->db->order_by('id_status_pembelian', 'desc');
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row()->status_pembelian;
    }
}

/* End of file Status_pembelian_m.php */