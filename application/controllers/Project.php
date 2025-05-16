<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_role_administrator();
        $this->load->model('Project_m');
        $this->load->model('Users_m');
        $this->load->helper('rupiah');

    }


    public function index()
    {
        $data['project'] = $this->Project_m->get_all_project();
        $this->template->load('shared/index', 'project/index', $data);
    }

    public function create()
    {
        $project = $this->Project_m;
        $validation = $this->form_validation;
        $validation->set_rules($project->rules());
        if ($validation->run() == FALSE) {
            $data['user'] = $this->Users_m->get_all_users();
            $this->template->load('shared/index', 'project/create', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $project->add_project($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data project berhasil disimpan!');
                redirect('project', 'refresh');
            }
        }

    }
    function update($id = null)
    {
        if (!isset($id))
            redirect('project');
        $project = $this->Project_m;
        $validation = $this->form_validation;
        $validation->set_rules($project->rules());
        if ($this->form_validation->run()) {
            $post = $this->input->post(null, TRUE);
            $project->update($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data Project Berhasil Diupdate!');
                redirect('project', 'refresh');
            } else {
                $this->session->set_flashdata('warning', 'Data Project Tidak Diupdate!');
                redirect('project', 'refresh');
            }
        }
        $data['project'] = $this->Project_m->get_project_by_id(decrypt_url($id));
        if (!$data['project']) {
            $this->session->set_flashdata('error', 'Data Project Tidak ditemukan!');
            redirect('project', 'refresh');
        }
        $data['user'] = $this->Users_m->get_all_users();
        $this->template->load('shared/index', 'project/update', $data);
    }
    public function delete($id)
    {
        $this->Project_m->delete_project(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data project berhasil dihapus!');
            redirect('project', 'refresh');
        }
    }

}

/* End of file Project.php */