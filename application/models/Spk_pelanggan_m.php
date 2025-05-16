<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spk_pelanggan_m extends CI_Model
{
    private $_table = 'spk_pelanggan';
    public $no_spk;
    public $id_user;
    public $id_jenis_pekerjaan;
    public $id_project;
    public $tgl_spk;
    public $id_pelanggan;
    public $alamat_site;
    public $telepon_pic_site;
    public $pic_site;
    public $no_layanan;
    public $note_spk;
    public $no_urut_spk;
    public $created_by;
    public $created_date;
    public $deleted;

    public function rules_spk()
    {
        return [
            [
                'field' => 'fid_user',
                'label' => 'nama karyawan',
                'rules' => 'required'
            ],
            [
                'field' => 'fnama_project',
                'label' => 'project',
                'rules' => 'required'
            ],
            [
                'field' => 'ftgl_spk',
                'label' => 'tanggal spk',
                'rules' => 'required'
            ],
            [
                'field' => 'fjenis_pekerjaan',
                'label' => 'jenis pekerjaaan',
                'rules' => 'required'
            ],
            [
                'field' => 'fnama_site',
                'label' => 'nama site',
                'rules' => 'required'
            ],
            [
                'field' => 'falamat_site',
                'label' => 'alamat site',
                'rules' => 'required'
            ],
            [
                'field' => 'fpic_site',
                'label' => 'PIC site',
                'rules' => 'required'
            ],
            [
                'field' => 'fno_layanan',
                'label' => 'Nomor layanan',
                'rules' => 'required'
            ],

            [
                'field' => 'ftelepon_pic_site',
                'label' => 'telepon PIC site',
                'rules' => 'required|numeric'
            ],
        ];
    }
    public function get_all_spk_pelanggan()
{
    $this->db->select('*');
    $this->db->join('users', 'users.id_user= spk_pelanggan.id_user', 'left');
    $this->db->join('customers', 'customers.uid_customer= spk_pelanggan.id_pelanggan', 'left');
    $this->db->join('jenis_pekerjaan', 'jenis_pekerjaan.id_jenis_pekerjaan= spk_pelanggan.id_jenis_pekerjaan', 'left');
    $this->db->join('project', 'project.project_id= spk_pelanggan.id_project', 'left');
    if ($this->session->userdata('nama_group') == 'teknisi') {
        $this->db->where('spk_pelanggan.id_user', $this->session->userdata('id_user'));
    }
    $this->db->where('spk_pelanggan.deleted', 0); // Hanya data yang belum dihapus
    $this->db->order_by('spk_pelanggan.no_urut_spk', 'DESC'); // Urutkan berdasarkan no_urut_spk
    $this->db->from($this->_table);
    $query = $this->db->get();
    return $query->result();
}
    public function get_spk_pelanggan_by_id($id_spk)
    {
        $this->db->select('spk_pelanggan.*, users.nama_user, users.id_user,users.phone_user, jenis_pekerjaan.*, project.*, customers.*');
        $this->db->join('customers', 'customers.uid_customer= spk_pelanggan.id_pelanggan', 'left');
        $this->db->join('users', 'users.id_user= spk_pelanggan.id_user', 'left');
        $this->db->join('jenis_pekerjaan', 'jenis_pekerjaan.id_jenis_pekerjaan= spk_pelanggan.id_jenis_pekerjaan', 'left');
        $this->db->join('project', 'project.project_id= spk_pelanggan.id_project', 'left');
        if ($this->session->userdata('nama_group') == 'teknisi') {
            $this->db->where('spk_pelanggan.id_user', $this->session->userdata('id_user'));
        }
        $this->db->where('spk_pelanggan.id_spk_pelanggan', $id_spk);
        $this->db->where('spk_pelanggan.deleted', 0);
        $this->db->order_by('spk_pelanggan.id_spk_pelanggan', 'DESC');
        $this->db->from($this->_table, $this);
        $query = $this->db->get();
        return $query->row();
    }
    public function add_spk_pelanggan()
    {
        $post = $this->input->post();
        $this->no_spk = 'GSK/' . date('dmy') . '/CUS/' . sprintf("%04d", $this->get_no_urut_spk());
        $this->id_user = decrypt_url($post['fid_user']);
        $this->id_jenis_pekerjaan = $post['fjenis_pekerjaan'];
        $this->id_project = $post['fid_project'];
        $this->tgl_spk = $post['ftgl_spk'];
        $this->id_pelanggan = $post['fid_pelanggan'];
        $this->no_layanan = $post['fno_layanan'];
        $this->alamat_site = $post['falamat_site'];
        $this->telepon_pic_site = $post['ftelepon_pic_site'];
        $this->pic_site = $post['fpic_site'];
        $this->note_spk = $post['fnote'];
        $this->no_urut_spk = $this->get_no_urut_spk();
        $this->created_by = $this->session->userdata('id_user');
        $this->created_date = Date('Y-m-d h:i:s');
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    public function update_spk_pelanggan($id_spk, $post)
    {
        $post = $this->input->post();
        $this->db->set('id_user', decrypt_url($post['fid_user']));
        $this->db->set('id_jenis_pekerjaan', $post['fjenis_pekerjaan']);
        $this->db->set('id_project', $post['fid_project']);
        $this->db->set('tgl_spk', $post['ftgl_spk']);
        $this->db->set('no_layanan', $post['fno_layanan']);
        $this->db->set('id_pelanggan', $post['fid_pelanggan']);
        $this->db->set('alamat_site', $post['falamat_site']);
        $this->db->set('telepon_pic_site', $post['ftelepon_pic_site']);
        $this->db->set('pic_site', $post['fpic_site']);
        $this->db->set('note_spk', $post['fnote']);
        $this->db->set('note_spk', $post['fnote']);
        $this->created_by = $this->session->userdata('id_user');
        $this->created_date = Date('Y-m-d h:i:s');
        $this->db->where('id_spk_pelanggan', decrypt_url($id_spk));
        $this->db->update($this->_table);
    }
    function get_no_urut_spk()
    {
        $this->db->select('no_urut_spk');
        $this->db->from($this->_table);
        $this->db->order_by('id_spk_pelanggan', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row()->no_urut_spk + 1;
    }
    public function delete_spk_pelanggan($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_spk_pelanggan', $id);
        $this->db->update($this->_table);
    }
}

/* End of file Spk_m.php */
