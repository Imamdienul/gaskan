<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item_pembelian_m extends CI_Model
{

    private $_table = 'item_pembelian';
    public $id_item_pembelian;
    public $no_pembelian;
    public $nama_barang;
    public $harga_satuan;
    public $total_harga;
    public $qty;
    public $satuan;
    public $spesifikasi;
    public $note;
    public $created_date;
    public function add_item_pembelian($data)
    {
        return $this->db->insert_batch($this->_table, $data);
    }
    public function total_pembelian_by_no_pembelian($no_pembelian)
    {
        $this->db->select_sum('total_harga');
        $this->db->where('no_pembelian', $no_pembelian);
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row()->total_harga;
    }
    public function get_item_by_no_pembelian($no_pembelian)
    {
        $this->db->select('item_pembelian.*');
        $this->db->where('no_pembelian', $no_pembelian);
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->result();
    }
}

/* End of file Item_pembelian_m.php */