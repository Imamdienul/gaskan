<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_barang_m extends CI_Model
{
    private $_table = 'master_barang';
    public $nama_barang;
    public $kode_barang;
    public $no_urut_barang;
    public $deleted;
    public function rules_master_barang()
    {
        return [
            [
                'field' => 'fkode_barang',
                'label' => 'kode barang',
                'rules' => 'required|is_unique[master_barang.kode_barang]'
            ],
            [
                'field' => 'fnama_barang',
                'label' => 'nama barang',
                'rules' => 'required'
            ],
        ];
    }
    public function get_all_master_barang()
    {
        $this->db->select('*');
        $this->db->where('deleted', 0);
        $this->db->order_by('nama_barang', 'asc');
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->result();
    }
    public function add_master_barang()
    {
        $post = $this->input->post();
        $this->kode_barang = 'BRG' . sprintf("%04d", $this->get_no_urut_barang());
        $this->no_urut_barang = $this->get_no_urut_barang();
        $this->nama_barang = $post['fnama_barang'];
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    public function delete_master_barang($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_master_barang', $id);
        $this->db->update($this->_table);
    }
    function get_no_urut_barang()
    {
        $this->db->select('no_urut_barang');
        $this->db->from($this->_table);
        $this->db->order_by('id_master_barang', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row()->no_urut_barang + 1;
    }
}

/* End of file Master_barang_m.php */
