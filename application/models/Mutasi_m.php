<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi_m extends CI_Model
{

    private $_table = 'mutasi_inventory';
    public $no_mutasi;
    public $nomor_registrasi;
    public $no_urut_mutasi;
    public $tgl_mutasi;
    public $lokasi_barang;
    public $created_by;
    public $created_date;
    public $note;
    public $deleted;

    public function rules_mutasi()
    {
        return [
            [
                'field' => 'fno_regis',
                'label' => 'nomor register',
                'rules' => 'required'
            ],
            [
                'field' => 'finventory',
                'label' => 'nama barang',
                'rules' => 'required'
            ],
            [
                'field' => 'ftgl_mutasi',
                'label' => 'tanggal mutasi',
                'rules' => 'required'
            ],
            [
                'field' => 'flokasi_barang',
                'label' => 'lokasi barang',
                'rules' => 'required'
            ],
        ];
    }
    public function get_all_mutasi()
{
    $this->db->select('mutasi_inventory.*, inventory.*, master_barang.nama_barang');
    $this->db->from($this->_table);
    $this->db->join('inventory', 'inventory.nomor_registrasi = mutasi_inventory.nomor_registrasi', 'left');
    $this->db->join('master_barang', 'master_barang.kode_barang = inventory.id_master_barang', 'left');
    $this->db->where('mutasi_inventory.deleted', 0);
    $query = $this->db->get();
    return $query->result();
}
    public function get_mutasi_by_id($id_mutasi)
    {
        $this->db->select('*');
        $this->db->join('inventory', 'inventory.nomor_registrasi= mutasi_inventory.nomor_registrasi', 'left');
        $this->db->join('master_barang', 'inventory.id_master_barang= master_barang.kode_barang', 'left');
        $this->db->where('mutasi_inventory.deleted', 0);
        $this->db->where('mutasi_inventory.id_mutasi', $id_mutasi);
        $this->db->from($this->_table, $this);
        $query = $this->db->get();
        return $query->row();
    }
    public function get_mutasi_by_no_registrasi($no_registrasi)
    {
        $this->db->select('*');
        $this->db->join('inventory', 'inventory.nomor_registrasi= mutasi_inventory.nomor_registrasi', 'left');
        $this->db->where('mutasi_inventory.deleted', 0);
        $this->db->where('mutasi_inventory.nomor_registrasi', $no_registrasi);
        $this->db->order_by('id_mutasi', 'desc');

        $this->db->from($this->_table, $this);
        $query = $this->db->get();
        return $query->result();
    }
    public function add_mutasi()
    {
        $post = $this->input->post();
        $this->no_mutasi = date('dmy') . sprintf("%04d", $this->get_no_urut_mutasi());
        $this->nomor_registrasi = $post['fno_regis'];
        $this->no_urut_mutasi = $this->get_no_urut_mutasi();
        $this->tgl_mutasi = $post['ftgl_mutasi'];
        $this->lokasi_barang = $post['flokasi_barang'];
        $this->created_by = $this->session->userdata('id_user');
        $this->created_date = Date('Y-m-d h:i:s');
        $this->note = $post['fnote'];
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    public function update_mutasi($id_mutasi, $post)
    {
        $post = $this->input->post();
        $this->db->set('nomor_registrasi', $post['fno_regis']);
        $this->db->set('tgl_mutasi', $post['ftgl_mutasi']);
        $this->db->set('lokasi_barang', $post['flokasi_barang']);
        $this->db->set('created_by', $this->session->userdata('id_user'));
        $this->db->set('created_date', Date('Y-m-d h:i:s'));
        $this->db->set('note', $post['fnote']);
        $this->db->where('id_mutasi', $id_mutasi);
        $this->db->update($this->_table);
    }
    public function delete_mutasi($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_mutasi', $id);
        $this->db->update($this->_table);
    }
    function get_no_urut_mutasi()
    {
        $this->db->select('no_urut_mutasi');
        $this->db->from($this->_table);
        $this->db->order_by('id_mutasi', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row()->no_urut_mutasi + 1;
    }
}

/* End of file Mutasi_m.php */
