<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_keuangan_m extends CI_Model
{

    private $_table = 'kategori_keuangan';
    public $id_kategori_keuangan;
    public $kategori_keuangan;
    public $default_nominal;
    public $deleted;
    public function rules_kategori_keuangan()
    {
        return [
            [
                'field' => 'fkategori_keuangan',
                'label' => 'kategori keuangan',
                'rules' => 'required'
            ],
            [
                'field' => 'fnominal',
                'label' => 'nominal',
                'rules' => 'required'
            ],
        ];
    }
    public function get_all_kategori_keuangan()
    {
        return $this->db->get_where($this->_table, ["deleted" => 0])->result();
    }
    function get_default_nominal($id)
    {
        $this->db->select('default_nominal');
        $this->db->where('id_kategori_keuangan', $id);

        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row()->default_nominal;
    }
    function get_by_id_kategori($id)
    {
        $this->db->select('*');
        $this->db->where('id_kategori_keuangan', $id);
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row();
    }
    public function add_kategori_keuangan()
    {
        $post = $this->input->post();
        $this->kategori_keuangan = $post['fkategori_keuangan'];
        $this->default_nominal = str_replace(".", "", $post['fnominal']);
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    public function update_kategori_keuangan($id, $post)
    {
        $post = $this->input->post();
        $this->db->set('kategori_keuangan', $post['fkategori_keuangan']);
        $this->db->set('default_nominal', str_replace(".", "", $post['fnominal']));
        $this->db->where('id_kategori_keuangan', $id);
        $this->db->update($this->_table);
    }
    public function delete_kategori_keuangan($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_kategori_keuangan', $id);
        $this->db->update($this->_table);
    }
}

/* End of file Kategori_keuangan_m.php */
