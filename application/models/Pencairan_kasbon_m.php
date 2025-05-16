<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pencairan_kasbon_m extends CI_Model
{

    private $_table = 'pencairan_kasbon';
    public $id_pencairan_kasbon;
    public $id_kasbon;
    public $tgl_pencairan;
    public $bukti_pencairan;
    public $created_by;
    public function rules()
    {
        return [
            [
                'field' => 'ftgl_pencairan',
                'label' => 'Tanggal pencairan',
                'rules' => 'required'
            ],
        ];
    }
    public function add_pencairan_kasbon($filename)
    {
        $post = $this->input->post();
        $this->id_kasbon = decrypt_url($post['fid_kasbon']);
        $this->tgl_pencairan = $post['ftgl_pencairan'];
        $this->bukti_pencairan = $filename;
        $this->created_by = $this->session->userdata('id_user');
        $this->db->insert($this->_table, $this);
    }
}

/* End of file Pencairan_kasbon_m.php */