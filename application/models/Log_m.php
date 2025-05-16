<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log_m extends CI_Model
{
    private $_table = 'log';
    public function get_all_log()
    {
        $this->db->select('*');
        $this->db->join('users', 'users.id_user= log.id_user', 'left');
        $this->db->from($this->_table, $this);
        $this->db->order_by('id_log', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function create_log($deskripsi)
    {
        $this->load->library('user_agent');
        $browser = $this->agent->browser();
        $browser_version = $this->agent->version();
        $os = $this->agent->platform();
        $address = $this->input->ip_address();
        $id_user = $this->session->userdata('id_user');
        $time = date('Y-m-d h:i:sa');
        $insert_user_sp = "CALL SP_CREATE_LOG(?,?,?,?,?,?,?)";
        $data = array('fdeskripsi' => $deskripsi,  'fid_user' => $id_user, 'flog_time' => $time, 'fos' => $os, 'fbrowser' => $browser, 'fbrowser_version' => $browser_version, 'faddress' => $address);
        $result = $this->db->query($insert_user_sp, $data);
        // if ($result !== NULL) {
        //     return TRUE;
        // }
        // return FALSE;
    }
}

/* End of file Log_m.php */
