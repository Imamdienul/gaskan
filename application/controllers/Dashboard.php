<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model('Users_m');
		$this->load->model('Pembelian_m');
		$this->load->helper(['Rupiah', 'formatdate', 'pembelian', 'project', 'Status_pembelian']);



	}

	public function index()
	{
		$data['isdefault'] = $this->Users_m->password_is_default($this->session->userdata('id_user'));
		$data['pembelian'] = $this->Pembelian_m->get_all_by_project_manager($this->session->userdata('id_user'));
		$this->template->load('shared/index', 'dashboard', $data);
	}
}