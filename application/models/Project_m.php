<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project_m extends CI_Model
{
    private $_table = 'project';
    public $project_id;
    public $nama_project;
    public $nomor_spk;
    public $project_owner;
    public $project_deadline;
    public $project_value;
    public $project_location;
    public $created_date;
    public $project_manager;
    public $created_by;
    public $deleted;
    public function rules()
    {
        return [
            [
                'field' => 'fno_spk',
                'label' => 'nomor SPK/PO',
                'rules' => 'required'
            ],
            [
                'field' => 'fnama_project',
                'label' => 'nama project',
                'rules' => 'required'
            ],
            [
                'field' => 'fproject_owner',
                'label' => 'project owner',
                'rules' => 'required'
            ],
            [
                'field' => 'fproject_manager',
                'label' => 'project manager',
                'rules' => 'required'
            ],
            [
                'field' => 'fproject_deadline',
                'label' => 'project deadline',
                'rules' => 'required'
            ],
            [
                'field' => 'fproject_value',
                'label' => 'nilai project',
                'rules' => 'required'
            ],
            [
                'field' => 'fproject_location',
                'label' => 'lokasi project',
                'rules' => 'required'
            ],
        ];
    }
    public function get_all_project()
{
    $this->db->select('*, users.nama_user');
    $this->db->from($this->_table);
    $this->db->join('users', 'users.id_user = project.project_manager', 'left');
    $this->db->where('project.deleted', 0);
    $this->db->where('project.project_deadline >=', date('Y-m-d')); // Filter deadline
    $this->db->order_by('project_id', 'desc');
    $query = $this->db->get();
    return $query->result();
}

    public function get_all_project_for_pembelian()
    {
        $this->db->select('*, users.nama_user');
        $this->db->from($this->_table);
        $this->db->join('users', 'users.id_user = project.project_manager', 'left');
        $this->db->where('project.deleted', 0);
        $this->db->where('project.project_deadline >', date('Y-m-d'));
        $this->db->order_by('project_id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_project_by_id($id)
    {
        $this->db->select('*, users.nama_user');
        $this->db->from($this->_table);
        $this->db->join('users', 'users.id_user = project.created_by', 'left');
        $this->db->where('project.project_id', $id);
        $this->db->where('project.deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function get_project_manager_by_id_project($id)
    {
        $this->db->select('*, users.nama_user');
        $this->db->from($this->_table);
        $this->db->join('users', 'users.id_user = project.project_manager', 'left');
        $this->db->where('project.project_id', $id);
        $this->db->where('project.deleted', 0);
        $query = $this->db->get();
        return $query->row()->nama_user;
    }
    public function add_project()
    {
        $post = $this->input->post();
        $this->nama_project = $post['fnama_project'];
        $this->nomor_spk = $post['fno_spk'];
        $this->project_owner = $post['fproject_owner'];
        $this->project_deadline = $post['fproject_deadline'];
        $this->project_manager = $post['fproject_manager'];
        $this->project_location = $post['fproject_location'];
        $this->project_value = str_replace(".", "", $post['fproject_value']);
        $this->created_by = $this->session->userdata('id_user');
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    public function update($post)
    {
        $post = $this->input->post();
        $this->db->set('nama_project', $post['fnama_project']);
        $this->db->set('nomor_spk', $post['fno_spk']);
        $this->db->set('project_owner', $post['fproject_owner']);
        $this->db->set('project_manager', $post['fproject_manager']);
        $this->db->set('project_deadline', $post['fproject_deadline']);
        $this->db->set('project_location', $post['fproject_location']);
        $this->db->set('project_value', str_replace(".", "", $post['fproject_value']));
        $this->db->where('project_id', decrypt_url($post['fid']));
        $this->db->update($this->_table);
    }
    public function delete_project($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('project_id', $id);
        $this->db->update($this->_table);
    }

}

/* End of file Project_m.php */