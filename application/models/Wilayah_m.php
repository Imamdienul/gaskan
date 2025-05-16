<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah_m extends CI_Model
{

    private $_table = 'wilayah';
    public $id_wilayah;
    public $nama_wilayah;
    public $kecamatan;
    public $kabupaten;
    public $provinsi;
    public $deleted;
    public function rules()
    {
        return [
            [
                'field' => 'fnama_wilayah',
                'label' => 'name wilayah',
                'rules' => 'required'
            ],
            [
                'field' => 'fkecamatan',
                'label' => 'kecamatan',
                'rules' => 'required'
            ],
            [
                'field' => 'fkabupaten',
                'label' => 'kabupaten / kota',
                'rules' => 'required'
            ],
            [
                'field' => 'fprovinsi',
                'label' => 'provinsi',
                'rules' => 'required'
            ],

        ];
    }
    public function get_all_wilayah()
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('wilayah.deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    function add_wilayah()
    {
        $post = $this->input->post();
        $this->nama_wilayah = $post['fnama_wilayah'];
        $this->kecamatan = $post['fkecamatan'];
        $this->kabupaten = $post['fkabupaten'];
        $this->provinsi = $post['fprovinsi'];
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    public function delete_wilayah($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_wilayah', $id);
        $this->db->update($this->_table);
    }
}

/* End of file Wilayah_m.php */