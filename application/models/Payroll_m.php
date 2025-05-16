<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payroll_m extends CI_Model
{
    private $_table = 'benefit';
    public $id_benefit;
    public $kode_benefit;
    public $id_user;
    public $nama_benefit;
    public $nominal_benefit;
    public $deleted;
    public function rules_set_benefit()
    {
        return [
            [
                'field' => 'fkode_benefit',
                'label' => 'kode benefit',
                'rules' => 'required'
            ],
            [
                'field' => 'fnama_benefit',
                'label' => 'nama banefit',
                'rules' => 'required'
            ],
            [
                'field' => 'fnominal_benefit',
                'label' => 'nominal',
                'rules' => 'required'
            ],
        ];
    }
    public function rules_payslip()
    {
        return [
            [
                'field' => 'fkaryawan',
                'label' => 'karyawan',
                'rules' => 'required'
            ],
            [
                'field' => 'fbulan',
                'label' => 'periode bulan',
                'rules' => 'required'
            ],
            [
                'field' => 'ftahun',
                'label' => 'periode tahun',
                'rules' => 'required'
            ],
        ];
    }
    public function add_benefit($id_user, $post)
    {
        $post = $this->input->post();
        $this->id_user = decrypt_url($id_user);
        $this->kode_benefit = $post['fkode_benefit'];
        $this->nama_benefit = $post['fnama_benefit'];
        $this->nominal_benefit = str_replace(".", "", $post['fnominal_benefit']);
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    public function get_benefit_by_id_user($id_user)
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('benefit.deleted', 0);
        $this->db->where('id_user', $id_user);
        $this->db->order_by('kode_benefit', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_total_benefit_by_id_user($id_user)
    {
        $this->db->select_sum('nominal_benefit');
        $this->db->from($this->_table);
        $this->db->where('benefit.deleted', 0);
        $this->db->where('id_user', $id_user);
        $this->db->order_by('kode_benefit', 'asc');
        $query = $this->db->get();
        return $query->row()->nominal_benefit;
    }
    public function delete_benefit($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_benefit', $id);
        $this->db->update($this->_table);
    }
}

/* End of file Payroll_m.php */
