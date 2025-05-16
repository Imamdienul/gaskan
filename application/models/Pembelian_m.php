<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian_m extends CI_Model
{
    private $_table = 'pembelian';
    public $id_pembelian;
    public $no_pembelian;
    public $id_user;
    public $project_id;
    public $note_pembelian;
    public $deadline_pembelian;
    public $no_urut_pembelian;
    public $created_date;
    public $deleted;
    public function rules()
    {
        return [
            [
                'field' => 'fproject',
                'label' => 'nama project',
                'rules' => 'required'
            ],
            [
                'field' => 'fno_pembelian',
                'label' => 'nomor pembelian',
                'rules' => 'required'
            ],
            [
                'field' => 'fdeadline_pembelian',
                'label' => 'deadline pembelian',
                'rules' => 'required'
            ],
            [
                'field' => 'fnama_barang[]',
                'label' => 'item',
                'rules' => 'required'
            ],
            [
                'field' => 'fharga_satuan[]',
                'label' => 'item',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'fqty[]',
                'label' => 'item',
                'rules' => 'required'
            ],
            [
                'field' => 'fspesifikasi[]',
                'label' => 'item',
                'rules' => 'required'
            ],
            [
                'field' => 'fnote[]',
                'label' => 'item',
                'rules' => 'required'
            ],
        ];
    }
    public function delete_by_id($id_pembelian) {
        $this->db->where('id_pembelian', $id_pembelian);
        return $this->db->delete('pembelian');
    }

    public function get_all_pembelian()
    {
        $this->db->select('*, users.nama_user, project.nama_project, pembelian.created_date');
        $this->db->from($this->_table);
        $this->db->join('users', 'users.id_user = pembelian.id_user', 'left');
        $this->db->join('project', 'project.project_id = pembelian.project_id', 'left');
        $this->db->where('pembelian.deleted', 0);
        if ($this->session->userdata('group') != 1 && $this->session->userdata('group') != 11) {
    $this->db->where('pembelian.id_user', $this->session->userdata('id_user'));
}

        $this->db->order_by('pembelian.id_pembelian', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_all_by_project_manager($id_user)
    {
        $this->db->select('*, users.nama_user, project.nama_project, pembelian.created_date');
        $this->db->join('project', 'project.project_id = pembelian.project_id', 'left');
        $this->db->join('users', 'users.id_user = project.project_manager', 'left');
        $this->db->where('pembelian.deleted', 0);
        $this->db->where('project.project_manager', $id_user);
        $this->db->order_by('pembelian.id_pembelian', 'desc');
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->result();
    }
    public function add_pembelian($no_pembelian, $post)
    {
        $post = $this->input->post();
        $this->note_pembelian = $post['fcatatan'];
        $this->no_pembelian = strtoupper(sprintf("%04d", $this->get_no_urut_pembelian()) . '/PR/' . bulanRomawi(date('m')) . '/' . date('Y'));
        $this->no_urut_pembelian = $this->get_no_urut_pembelian();
        $this->deadline_pembelian = $post['fdeadline_pembelian'];
        $this->id_user = $this->session->userdata('id_user');
        $this->project_id = $post['fid_project'];
        $this->created_date = Date('Y-m-d h:i:s');
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    function get_no_pembelian()
    {
        date_default_timezone_set('Asia/Jakarta');
        $q = $this->db->query("SELECT MAX(RIGHT(id_pembelian,4)) AS id_max FROM pembelian WHERE DATE(created_date)=CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->id_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        return date('dmy') . $kd;
    }
    function get_no_urut_pembelian()
    {
        $this->db->select('no_urut_pembelian');
        $this->db->from($this->_table);
        $this->db->order_by('id_pembelian', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if (date('m') == 1 && date('d') == 1) {
            return 1;
        } else {
            return $query->row()->no_urut_pembelian + 1;
        }
    }
    public function get_by_id_pembelian($id)
    {
        $this->db->select('pembelian.*, users.nama_user, users.nik, project.nama_project, project.project_owner, project.project_deadline, project.project_location');
        $this->db->join('users', 'users.id_user = pembelian.id_user', 'left');
        $this->db->join('project', 'project.project_id = pembelian.project_id', 'left');
        $this->db->where('pembelian.deleted', 0);
        $this->db->where('pembelian.id_pembelian', $id);
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row();
    }
}

/* End of file Pembelian_m.php */