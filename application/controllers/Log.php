<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_role_administrator();
        $this->load->model(['Log_m']);
    }


    public function index()
    {
        $data['log'] = $this->Log_m->get_all_log();
        $this->template->load('shared/index', 'log/index', $data);
    }
}

/* End of file Log.php */
