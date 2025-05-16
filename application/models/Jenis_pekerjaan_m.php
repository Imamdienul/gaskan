<?php defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_pekerjaan_m extends CI_Model
{

    private $_table = 'jenis_pekerjaan';
    public $id_jenis_pekerjaan;
    public $jenis_pekerjaan;
    public $nominal;
    public $deleted;
    public function rules_jenis_pekerjaan()
    {
        return [
            [
                'field' => 'fjenis_pekerjaan',
                'label' => 'jenis pekerjaan',
                'rules' => 'required'
            ],
            [
                'field' => 'fnominal',
                'label' => 'nominal',
                'rules' => 'required'
            ],
        ];
    }
    public function get_all_jenis_pekerjaan()
    {
        return $this->db->get_where($this->_table, ["deleted" => 0])->result();
    }
    public function add_jenis_pekerjaan()
    {
        $post = $this->input->post();
        $this->jenis_pekerjaan = $post['fjenis_pekerjaan'];
        $this->nominal = str_replace(".", "", $post['fnominal']);
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    public function delete_jenis_pekerjaan($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_jenis_pekerjaan', $id);
        $this->db->update($this->_table);
    }
}

/* End of file Jenis_pekerjaan_m.php */
