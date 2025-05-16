<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan_m extends CI_Model
{

    public function rules_ganti_pass()
    {
        return [
            [
                'field' => 'fpwd_lama',
                'label' => 'password lama',
                'rules' => 'required'
            ],
            [
                'field' => 'fpwd_baru',
                'label' => 'password baru',
                'rules' => 'required|min_length[8]'
            ],
            [
                'field' => 'fpwd_baru_conf',
                'label' => 'ulangi password baru',
                'rules' => 'required|matches[fpwd_baru]'
            ],
        ];
    }

}

/* End of file Pengaturan_m.php */