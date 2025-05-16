<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_layanan_m extends CI_Model
{

    private $_table = 'profile_layanan';
    public $id_profile_layanan;
    public $nama_profile;
    public $mikrotik_group;
    public $rate_limit;
    public $shared;
    public $masa_aktif;
    public $komisi;
    public $harga;
    public $is_aktif;
    public $deleted;
    public function rules()
    {
        return [
            [
                'field' => 'fnama_profile',
                'label' => 'nama profile',
                'rules' => 'required'
            ],
            [
                'field' => 'fmikrotik_group',
                'label' => 'mikrotik group',
                'rules' => 'required'
            ],
            [
                'field' => 'frate_limit',
                'label' => 'mikrotik rate limit',
                'rules' => 'required'
            ],
            [
                'field' => 'fshared',
                'label' => 'shared',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'fmasa_aktif',
                'label' => 'masa_aktif',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'fkomisi',
                'label' => 'komisi',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'fharga',
                'label' => 'harga',
                'rules' => 'required|numeric'
            ],

        ];
    }
    public function get_all_profile()
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    function add_profile_layanan()
    {
        $post = $this->input->post();
        $this->nama_profile = $post['fnama_profile'];
        $this->mikrotik_group = $post['fmikrotik_group'];
        $this->rate_limit = $post['frate_limit'];
        $this->shared = $post['fshared'];
        $this->masa_aktif = $post['fmasa_aktif'];
        $this->komisi = str_replace(".", "", $post['fkomisi']);
        $this->harga = str_replace(".", "", $post['fharga']);
        $this->is_aktif = 1;
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    public function delete_profile_layanan($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_profile_layanan', $id);
        $this->db->update($this->_table);
    }
    public function set_is_aktif($id, $val)
    {
        $this->db->set('is_aktif', $val);
        $this->db->where('id_profile_layanan', $id);
        $this->db->update($this->_table);
    }
}

/* End of file Wilayah_m.php */