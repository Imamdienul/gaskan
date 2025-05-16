<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_m extends CI_Model
{
    private $_table = 'inventory';
    public $nomor_registrasi;
    public $no_urut;
    public $id_master_barang;
    public $id_master_tipe;
    public $serial_number;
    public $mac_address;
    public $tgl_registrasi;
    public $suplyer;
    public $status_barang;
    public $jenis_barang;
    public $harga_barang;
    public $kondisi_barang;
    public $created_by;
    public $created_date;
    public $deleted;
    public function rules_inventory()
    {
        return [
            [
                'field' => 'fbarang',
                'label' => 'barang',
                'rules' => 'required'
            ],
            [
                'field' => 'ftipe',
                'label' => 'tipe barang',
                'rules' => 'required'
            ],
            [
                'field' => 'ftgl_registrasi',
                'label' => 'tanggal registrasi',
                'rules' => 'required'
            ],
            [
                'field' => 'fsuplyer',
                'label' => 'supplier',
                'rules' => 'required'
            ],
            [
                'field' => 'fstatus_barang',
                'label' => 'status barang',
                'rules' => 'required'
            ],
            [
                'field' => 'fkondisi_barang',
                'label' => 'kondisi barang',
                'rules' => 'required'
            ],
            [
                'field' => 'fharga_barang',
                'label' => 'harga barang',
                'rules' => 'required'
            ],
            [
                'field' => 'fjenis_barang',
                'label' => 'jenis barang',
                'rules' => 'required'
            ],
        ];
    }
    public function rules_update_inventory()
    {
        return [
            [
                'field' => 'fbarang',
                'label' => 'barang',
                'rules' => 'required'
            ],
            [
                'field' => 'ftipe',
                'label' => 'tipe barang',
                'rules' => 'required'
            ],
            [
                'field' => 'ftgl_registrasi',
                'label' => 'tanggal registrasi',
                'rules' => 'required'
            ],
            [
                'field' => 'fsuplyer',
                'label' => 'supplier',
                'rules' => 'required'
            ],
            [
                'field' => 'fstatus_barang',
                'label' => 'status barang',
                'rules' => 'required'
            ],
            [
                'field' => 'fkondisi_barang',
                'label' => 'kondisi barang',
                'rules' => 'required'
            ],
            [
                'field' => 'fharga_barang',
                'label' => 'harga barang',
                'rules' => 'required'
            ],
            [
                'field' => 'fjenis_barang',
                'label' => 'jenis barang',
                'rules' => 'required'
            ],
        ];
    }
    public function get_all_stok_inventory()
    {
        $sql = "SELECT * FROM inventory 
        LEFT JOIN master_tipe ON master_tipe.id_master_tipe = inventory.id_master_tipe 
        LEFT JOIN master_barang ON master_barang.kode_barang = inventory.id_master_barang 
        WHERE NOT EXISTS (SELECT * FROM mutasi_inventory WHERE inventory.nomor_registrasi = mutasi_inventory.nomor_registrasi) ORDER BY id_inventory DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_total_by_type()
    {
        $sql = "SELECT master_barang.nama_barang, count(master_barang.nama_barang) as total FROM inventory 
        -- LEFT JOIN master_tipe ON master_tipe.id_master_tipe = inventory.id_master_tipe 
        LEFT JOIN master_barang ON master_barang.kode_barang = inventory.id_master_barang 
        WHERE NOT EXISTS (SELECT * FROM mutasi_inventory WHERE inventory.nomor_registrasi = mutasi_inventory.nomor_registrasi) GROUP BY  master_barang.nama_barang";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_all_inventory()
    {
        $this->db->select('*');
        $this->db->join('master_barang', 'master_barang.kode_barang= inventory.id_master_barang', 'left');
        $this->db->join('master_tipe', 'master_tipe.id_master_tipe= inventory.id_master_tipe', 'left');
        $this->db->where('inventory.deleted', 0);
        $this->db->from($this->_table, $this);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_by_no_registrasi($no_regis)
    {
        $this->db->select('*');
        $this->db->join('master_barang', 'master_barang.kode_barang= inventory.id_master_barang', 'left');
        $this->db->join('master_tipe', 'master_tipe.id_master_tipe= inventory.id_master_tipe', 'left');
        $this->db->join('master_merek', 'master_tipe.id_master_merek= master_merek.id_master_merek', 'left');
        $this->db->where('inventory.deleted', 0);
        $this->db->where('inventory.nomor_registrasi', $no_regis);
        $this->db->from($this->_table, $this);
        $query = $this->db->get();
        return $query->row();
    }
    public function get_all_by_no_registrasi($no_regis)
    {
        $this->db->select('*');
        $this->db->join('master_barang', 'master_barang.kode_barang= inventory.id_master_barang', 'left');
        $this->db->join('master_tipe', 'master_tipe.id_master_tipe= inventory.id_master_tipe', 'left');
        $this->db->join('master_merek', 'master_tipe.id_master_merek= master_merek.id_master_merek', 'left');
        $this->db->where('inventory.deleted', 0);
        $this->db->where_in('inventory.nomor_registrasi', $no_regis);
        $this->db->from($this->_table, $this);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_by_id_inventory($id_inventory)
    {
        $this->db->select('*');
        $this->db->join('master_barang', 'master_barang.kode_barang= inventory.id_master_barang', 'left');
        $this->db->join('master_tipe', 'master_tipe.id_master_tipe= inventory.id_master_tipe', 'left');
        $this->db->join('master_merek', 'master_tipe.id_master_merek= master_merek.id_master_merek', 'left');
        $this->db->where('inventory.deleted', 0);
        $this->db->where('inventory.id_inventory', $id_inventory);
        $this->db->from($this->_table, $this);
        $query = $this->db->get();
        return $query->row();
    }
    public function add_inventory()
    {
        $post = $this->input->post();
        $this->nomor_registrasi = preg_replace("/[^0-9]/", "", $post['fbarang']) . sprintf("%04d", $this->get_no_urut_inventory());
        $this->no_urut = $this->get_no_urut_inventory();
        $this->id_master_barang = $post['fbarang'];
        $this->id_master_tipe = $post['fid_tipe'];
        $this->serial_number = $post['fserial_number'];
        $this->mac_address = $post['fmac_address'];
        $this->tgl_registrasi = $post['ftgl_registrasi'];
        $this->suplyer = $post['fsuplyer'];
        $this->status_barang = $post['fstatus_barang'];
        $this->jenis_barang = $post['fjenis_barang'];
        $this->harga_barang = str_replace(".", "", $post['fharga_barang']);
        $this->kondisi_barang = $post['fkondisi_barang'];
        $this->created_by = $this->session->userdata('id_user');
        $this->created_date = Date('Y-m-d h:i:s');
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    public function update_inventory($id_inventory, $post)
    {
        $post = $this->input->post();
        $this->db->set('id_master_barang', $post['fbarang']);
        $this->db->set('id_master_tipe', $post['fid_tipe']);
        $this->db->set('serial_number', $post['fserial_number']);
        $this->db->set('mac_address', $post['fmac_address']);
        $this->db->set('tgl_registrasi', $post['ftgl_registrasi']);
        $this->db->set('suplyer', $post['fsuplyer']);
        $this->db->set('status_barang', $post['fstatus_barang']);
        $this->db->set('jenis_barang', $post['fjenis_barang']);
        $this->db->set('harga_barang', str_replace(".", "", $post['fharga_barang']));
        $this->db->set('kondisi_barang', $post['fkondisi_barang']);
        $this->db->set('kondisi_barang', $post['fkondisi_barang']);
        $this->db->where('id_inventory', decrypt_url($id_inventory));
        $this->db->update($this->_table);
    }
    function get_no_urut_inventory()
    {
        $this->db->select('no_urut');
        $this->db->from($this->_table);
        $this->db->order_by('id_inventory', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row()->no_urut + 1;
    }
    function get_last_inventory()
    {
        $this->db->select('nomor_registrasi');
        $this->db->from($this->_table);
        $this->db->order_by('id_inventory', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row()->nomor_registrasi;
    }
    public function delete_inventory($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_inventory', $id);
        $this->db->update($this->_table);
    }
}

/* End of file Master_barang_m.php */
