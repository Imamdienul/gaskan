<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Status_kasbon_m extends CI_Model
{

    private $_table = 'status_kasbon';
    public $id_status_kasbon;
    public $no_dokumen;
    public $id_user;
    public $status_kasbon;
    public $note_status;
    public function add_status_created_kasbon()
    {
        $post = $this->input->post();
        $this->id_user = $this->session->userdata('id_user');
        $this->no_dokumen = $post['fno_dokumen'];
        $this->status_kasbon = 'created';
        $this->note_status = 'document has created';
        $this->db->insert($this->_table, $this);
    }
    public function get_all_status_kasbon_by_id($id_kasbon)
    {
        $this->db->select('status_kasbon.*, users.nama_user, pencairan_kasbon.bukti_pencairan');
        $this->db->from($this->_table);
        $this->db->join('kasbon', 'kasbon.no_dokumen = status_kasbon.no_dokumen', 'left');
        $this->db->join('users', 'users.id_user = status_kasbon.id_user', 'left');
        $this->db->join('pencairan_kasbon', 'pencairan_kasbon.id_kasbon = kasbon.id_kasbon', 'left');
        $this->db->order_by('status_kasbon.created_date_status', 'desc');

        $this->db->where('kasbon.id_kasbon', $id_kasbon);
        $query = $this->db->get();
        return $query->result();
    }

    public function add_status_approve_kasbon()
    {
        $post = $this->input->post();
        $this->id_user = $this->session->userdata('id_user');
        $this->no_dokumen = $post['fno_dokumen'];
        $this->status_kasbon = 'approved';
        $this->note_status = $post['fnote'];
        $this->db->insert($this->_table, $this);
    }
    public function add_status_reject_kasbon()
    {
        $post = $this->input->post();
        $this->id_user = $this->session->userdata('id_user');
        $this->no_dokumen = $post['fno_dokumen'];
        $this->status_kasbon = 'rejected';
        $this->note_status = $post['fnote'];
        $this->db->insert($this->_table, $this);
    }
    public function add_status_closed_kasbon()
    {
        $post = $this->input->post();
        $this->id_user = $this->session->userdata('id_user');
        $this->no_dokumen = $post['fno_dokumen'];
        $this->status_kasbon = 'closed';
        $this->note_status = $post['fnote'];
        $this->db->insert($this->_table, $this);
    }
    function cek_status($no_dokumen)
    {
        $this->db->select('no_dokumen');
        $this->db->where('no_dokumen', $no_dokumen);
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function cek_status_terkahir($no_dokumen)
    {
        $this->db->select('status_kasbon');
        $this->db->where('no_dokumen', $no_dokumen);
        $this->db->order_by('id_status_kasbon', 'desc');
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row()->status_kasbon;
    }
}

/* End of file Status_kasbon_m.php */