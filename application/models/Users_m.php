<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_m extends CI_Model
{
    private $_table = 'users';
    public $id_user;
    public $nik;
    public $no_rekening;
    public $tgl_join;
    public $bank;
    public $nama_user;
    public $email_user;
    public $phone_user;
    public $status_user;
    public $id_group_user;
    public $username;
    public $password;
    public $chat_id;
    public $verify_code;
    public $deleted;

    public function rules()
    {
        return [
            [
                'field' => 'fname_user',
                'label' => 'name user',
                'rules' => 'required'
            ],
            [
                'field' => 'femail_user',
                'label' => 'email user',
                'rules' => 'required|is_unique[users.email_user]|valid_email'
            ],
            [
                'field' => 'fphone_user',
                'label' => 'phone user',
                'rules' => 'required|is_unique[users.phone_user]'
            ],
            [
                'field' => 'fid_group_user',
                'label' => 'group user',
                'rules' => 'required'
            ],
            [
                'field' => 'fusername',
                'label' => 'username',
                'rules' => 'required|is_unique[users.username]'
            ],
            [
                'field' => 'fpassword',
                'label' => 'password',
                'rules' => 'required|min_length[8]'
            ],
            [
                'field' => 'fconfpassword',
                'label' => 'konfirmasi password',
                'rules' => 'required|matches[fpassword]'
            ],
            [
                'field' => 'fno_rekening',
                'label' => 'nomor rekening',
                'rules' => 'numeric'
            ],
            [
                'field' => 'ftgl_join',
                'label' => 'tanggal join',
                'rules' => 'required'
            ],
        ];
    }
    // In User_m.php
public function get_users_by_role($role_id) {
    $this->db->select('u.*');
    $this->db->from('users u');
    $this->db->join('group_users g', 'u.id_group_user = g.id_group_user');
    $this->db->where('g.id_group_user', $role_id);
    $this->db->where('u.status_user', 1);
    $this->db->where('u.deleted', 0);
    return $this->db->get()->result();
}

    public function update_role($post)
    {
        $this->db->set('id_group_user', $post['fid_group_user']);
        $this->db->where('id_user', decrypt_url($post['fid_user']));
        $this->db->update($this->_table);
    }

    public function rules_update_profile()
    {
        return [
            [
                'field' => 'fname_user',
                'label' => 'name user',
                'rules' => 'required'
            ],
            [
                'field' => 'femail_user',
                'label' => 'email user',
                'rules' => 'required|valid_email'
            ],
            [
                'field' => 'fphone_user',
                'label' => 'phone user',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'fno_rekening',
                'label' => 'nomor rekening',
                'rules' => 'numeric'
            ],
        ];
    }

    function get_chat_id_administrator()
    {
        $this->db->select('users.chat_id');
        $this->db->where('id_group_user', 1);
        $this->db->where('status_user', 1);
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->result();
    }

    function get_chat_id_by_no_dokumen($no_dokumen)
    {
        $this->db->select('kasbon.*, users.chat_id');
        $this->db->join('kasbon', 'users.id_user = kasbon.id_user', 'left');
        $this->db->where('no_dokumen', $no_dokumen);
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_all_users()
    {
        $this->db->select('users.id_user, users.nama_user, users.email_user, users.id_group_user, users.username, users.nik, users.phone_user, users.status_user, users.bank, users.no_rekening, users.tgl_join, group_users.group_user');
        $this->db->join('group_users', 'group_users.id_group_user = users.id_group_user', 'left');
        $this->db->where('users.deleted', 0);
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_users_active()
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->join('group_users', 'group_users.id_group_user = users.id_group_user', 'left');
        $this->db->where('users.deleted', 0);
        $this->db->where('users.status_user', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_id_user($id)
    {
        $this->db->select('users.id_user, users.nama_user, users.email_user, users.id_group_user, users.username, users.nik, users.phone_user, users.status_user, users.bank, users.no_rekening, users.tgl_join, group_users.group_user');
        $this->db->from($this->_table);
        $this->db->join('group_users', 'group_users.id_group_user = users.id_group_user', 'left');
        $this->db->where('users.id_user', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function add_user()
    {
        $post = $this->input->post();
        $this->nama_user = $post['fname_user'];
        $this->no_rekening = $post['fno_rekening'];
        $this->bank = $post['fbank'];
        $this->tgl_join = $post['ftgl_join'];
        $this->email_user = $post['femail_user'];
        $this->phone_user = $post['fphone_user'];
        $this->verify_code = random_string('numeric', 6);
        $this->chat_id = 0;
        $this->status_user = 1;
        $tgl_join = preg_replace("/[^0-9]/", "", $post['ftgl_join']);
        $thn_bln = substr($tgl_join, 2, 4);
        $no_urut = substr($this->get_last_nik(), 4) + 1;
        if (strlen($no_urut) == 1) {
            $no_urut_new = "00" . $no_urut;
        } else if (strlen($no_urut) == 2) {
            $no_urut_new = "0" . $no_urut;
        } else {
            $no_urut_new = $no_urut;
        }
        $this->nik = $thn_bln . $no_urut_new; //2023-06-19
        $this->id_group_user = $post['fid_group_user'];
        $this->username = $post['fusername'];
        $this->password = encrypt_url($post['fpassword']);
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }

    public function update($post)
    {
        $post = $this->input->post();
        $this->db->set('nama_user', $post['fname_user']);
        $this->db->set('no_rekening', $post['fno_rekening']);
        $this->db->set('bank', $post['fbank']);
        $this->db->set('email_user', $post['femail_user']);
        $this->db->set('phone_user', $post['fphone_user']);
        $this->db->where('id_user', decrypt_url($post['fid_user']));
        $this->db->update($this->_table);
    }

    public function delete_user($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_user', $id);
        $this->db->update($this->_table);
    }

    function get_last_nik()
    {
        $this->db->select('nik');
        $this->db->limit(1);
        $this->db->order_by('nik', 'desc');
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row()->nik;
    }

    public function login($post)
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('username', $post['fusername']);
        $this->db->where('status_user', 1);
        $this->db->where('password', encrypt_url($post['fpassword']));
        $this->db->join('group_users', 'group_users.id_group_user = users.id_group_user', 'left');
        $query = $this->db->get();
        return $query;
    }

    function cek_password_lama($id_user, $pwd)
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('id_user', $id_user);
        $this->db->where('password', encrypt_url($pwd));
        $query = $this->db->get();
        return $query->row();
    }

    function password_is_default($id_user)
    {
        $this->db->select('password');
        $this->db->from($this->_table);
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        $pwd = $query->row()->password;
        if (decrypt_url($pwd) == 'admin123') {
            return true;
        } else {
            return false;
        }
    }

    function ganti_password($id_user, $pwd)
    {
        $this->db->set('password', encrypt_url($pwd));
        $this->db->where('id_user', $id_user);
        $this->db->update($this->_table);
    }

    function aktif_nonaktif($id, $value)
    {
        $this->db->set('status_user', $value);
        $this->db->where('id_user', $id);
        $this->db->update($this->_table);
    }

    // New functions for remember me functionality
    
    public function save_remember_token($user_id, $token, $expire_time)
    {
        $data = [
            'id_user' => $user_id,
            'token' => $token,
            'expires' => date('Y-m-d H:i:s', $expire_time),
            'created_at' => date('Y-m-d H:i:s'),
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->agent->agent_string()
        ];
        
        // First delete any existing tokens for this user
        $this->db->where('id_user', $user_id);
        $this->db->delete('user_remember_tokens');
        
        // Then insert the new token
        $this->db->insert('user_remember_tokens', $data);
        return $this->db->affected_rows();
    }
    
    public function get_user_by_token($token)
    {
        $this->db->select('u.*, gu.group_user');
        $this->db->from('user_remember_tokens urt');
        $this->db->join($this->_table . ' u', 'u.id_user = urt.id_user');
        $this->db->join('group_users gu', 'u.id_group_user = gu.id_group_user');
        $this->db->where('urt.token', $token);
        $this->db->where('urt.expires >', date('Y-m-d H:i:s'));
        $this->db->where('u.status_user', 1);
        $this->db->where('u.deleted', 0);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        
        return false;
    }
    
    public function delete_remember_token($token)
    {
        $this->db->where('token', $token);
        $this->db->delete('user_remember_tokens');
        return $this->db->affected_rows();
    }
    // Add these methods to your Users_m model

public function get_user_by_email($email)
{
    $this->db->select('*');
    $this->db->from($this->_table);
    $this->db->where('email_user', $email);
    $this->db->where('status_user', 1);
    $this->db->where('deleted', 0);
    
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->row();
    }
    
    return false;
}

public function save_reset_token($user_id, $token, $expire_time)
{
    $data = [
        'id_user' => $user_id,
        'token' => $token,
        'expires' => date('Y-m-d H:i:s', $expire_time),
        'created_at' => date('Y-m-d H:i:s'),
        'ip_address' => $this->input->ip_address(),
        'user_agent' => $this->agent->agent_string()
    ];
    
    // First delete any existing reset tokens for this user
    $this->db->where('id_user', $user_id);
    $this->db->delete('password_reset_tokens');
    
    // Then insert the new token
    $this->db->insert('password_reset_tokens', $data);
    
    return $this->db->affected_rows();
}

public function get_user_by_reset_token($token)
{
    $this->db->select('u.*');
    $this->db->from('password_reset_tokens prt');
    $this->db->join($this->_table . ' u', 'u.id_user = prt.id_user');
    $this->db->where('prt.token', $token);
    $this->db->where('prt.expires >', date('Y-m-d H:i:s'));
    $this->db->where('u.status_user', 1);
    $this->db->where('u.deleted', 0);
    
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->row();
    }
    
    return false;
}

public function delete_reset_token($token)
{
    $this->db->where('token', $token);
    $this->db->delete('password_reset_tokens');
    
    return $this->db->affected_rows();
}
}

/* End of file Users_m.php */