<?php
defined('BASEPATH') or exit('No direct script access allowed');
class auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load only essential components in constructor
        $this->load->model('Users_m');
        $this->load->helper('cookie');
    }
    
    public function login()
    {
        $logged_out = get_cookie('logged_out');
        
        if (!$logged_out) {
            $remember_token = get_cookie('remember_token');
            
            if ($remember_token) {
                $user = $this->Users_m->get_user_by_token($remember_token);
                
                if ($user) {
                    $data['user'] = $user;
                    $this->load->view('auth/standby', $data);
                    return;
                } else {
                    delete_cookie('remember_token');
                }
            }
        } else {
            delete_cookie('logged_out');
        }
        
        check_already_login();
        $this->load->view('auth/login');
    }
    
    public function continue_session()
    {
        $remember_token = get_cookie('remember_token');
        $logged_out = get_cookie('logged_out');
        
        if ($logged_out) {
            delete_cookie('logged_out');
            redirect('auth/login', 'refresh');
            return;
        }
        
        if ($remember_token) {
            $user = $this->Users_m->get_user_by_token($remember_token);
            
            if ($user) {
                $params = array(
                    'id_user' => $user->id_user,
                    'email' => $user->email_user,
                    'nik' => $user->nik,
                    'group' => $user->id_group_user,
                    'nama_group' => $user->group_user,
                    'username' => $user->username,
                    'nama_user' => $user->nama_user,
                    'status' => 'login'
                );
                $this->session->set_userdata($params);
                
                // Log after session is established - load model only when needed
                $this->load->model('Log_m');
                $this->Log_m->create_log('continued session for username ' . $user->username);
                
                redirect('dashboard', 'refresh');
            } else {
                delete_cookie('remember_token');
                redirect('auth/login', 'refresh');
            }
        } else {
            redirect('auth/login', 'refresh');
        }
    }
    
    public function process()
    {
        $post = $this->input->post(null, TRUE);
        if ($post) {
            // Validate captcha first - load helper only when needed
            if ($post['flock'] != "true") {
                $this->session->set_flashdata('error', 'Captcha tidak cocok');
                redirect('auth/login', 'refresh');
                return;
            }
            
            $query = $this->Users_m->login($post);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                if ($row->chat_id == 0) {
                    $data['code'] = $row->verify_code;
                    $this->load->view('telegram/verify', $data);
                } else {
                    $params = array(
                        'id_user' => $row->id_user,
                        'email' => $row->email_user,
                        'nik' => $row->nik,
                        'group' => $row->id_group_user,
                        'nama_group' => $row->group_user,
                        'username' => $row->username,
                        'nama_user' => $row->nama_user,
                        'status' => 'login'
                    );
                    $this->session->set_userdata($params);
                    
                    delete_cookie('logged_out');
                    
                    if (isset($post['remember']) && $post['remember'] == 'on') {
                        $token = bin2hex(random_bytes(32));
                        $expire_time = time() + (86400 * 30); 
                        
                        $this->Users_m->save_remember_token($row->id_user, $token, $expire_time);
                        
                        set_cookie('remember_token', $token, $expire_time);
                    }
                    
                    // Log successful login - load model only when needed
                    $this->load->model('Log_m');
                    $this->Log_m->create_log('login username ' . $row->username);
                    
                    // Queue the email and telegram notification for background processing
                    $this->queue_login_notifications($row);
                    
                    redirect('dashboard', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'username / password salah');
                redirect('auth/login', 'refresh');
            }
        } else {
            redirect('auth/login', 'refresh');
        }
    }
    
    private function queue_login_notifications($user)
    {
        // Add to notification queue table instead of sending directly
        // This is a simplified example - implement a proper queue system
        $browser = $this->load->library('user_agent') ? $this->agent->browser().' '.$this->agent->version() : 'Unknown';
        $platform = $this->load->library('user_agent') ? $this->agent->platform() : 'Unknown';
        $ip_address = $this->input->ip_address();
        $login_time = date('d-m-Y H:i:s');
        
        $notification_data = [
            'user_id' => $user->id_user,
            'email' => $user->email_user,
            'username' => $user->username,
            'nama_user' => $user->nama_user,
            'notification_type' => 'login',
            'browser' => $browser,
            'platform' => $platform,
            'ip_address' => $ip_address,
            'login_time' => $login_time,
            'telegram_chat_id' => $user->chat_id,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Insert into notification queue table
        // This would be processed by a cron job or background worker
        $this->db->insert('notification_queue', $notification_data);
    }
    
    public function logout()
    {
        check_not_login();
        $params = array('id_user', 'email', 'nik', 'group', 'username', 'nama_user', 'status');
        $this->session->unset_userdata($params);
        
        $logged_out_expire = time() + (86400 * 30); 
        set_cookie('logged_out', '1', $logged_out_expire);
        
        if ($this->input->get('full_logout') == 'true') {
            $remember_token = get_cookie('remember_token');
            if ($remember_token) {
                $this->Users_m->delete_remember_token($remember_token);
                delete_cookie('remember_token');
            }
        }
        
        // Log the logout - load model only when needed
        $this->load->model('Log_m');
        $this->Log_m->create_log('logout user: ' . $this->session->userdata('username'));
        redirect('auth/login', 'refresh');
    }
    
    public function forgot_password()
    {
        $this->load->view('auth/forgot_password');
    }

    public function process_forgot_password()
    {
        $email = $this->input->post('email');
        
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->session->set_flashdata('error', 'Email tidak valid');
            redirect('auth/forgot_password');
            return;
        }
        
        // Check if email exists in database
        $user = $this->Users_m->get_user_by_email($email);
        
        if (!$user) {
            // We don't want to reveal if an email exists or not for security reasons
            // So we still show a success message
            $this->session->set_flashdata('success', 'Jika email terdaftar, instruksi reset password telah dikirim');
            redirect('auth/forgot_password');
            return;
        }
        
        // Generate reset token
        $token = bin2hex(random_bytes(4));
        $expire_time = time() + (60 * 60); // 1 hour expiration
        
        // Save token to database
        $this->Users_m->save_reset_token($user->id_user, $token, $expire_time);
        
        // Send reset email directly instead of queuing
        $reset_link = base_url('auth/reset_password/' . $token);
        $this->send_reset_email_directly($user, $reset_link);
        
        $this->load->model('Log_m');
        $this->Log_m->create_log('Reset password request for email ' . $email);
        $this->session->set_flashdata('success', 'Instruksi reset password telah dikirim ke email Anda');
        redirect('auth/forgot_password');
    }

    private function send_reset_email_directly($user, $reset_link)
    {
        // Load required library
        $this->load->library('email');
        $this->load->model('Log_m');
        
        $subject = 'Reset Password - Sistem';
        
        $message = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
                .header { background-color: #f5f5f5; padding: 10px; border-radius: 5px 5px 0 0; text-align: center; }
                .content { padding: 20px; }
                .button { display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; }
                .footer { background-color: #f5f5f5; padding: 10px; border-radius: 0 0 5px 5px; text-align: center; font-size: 12px; }
                .alert { color: #31708f; background-color: #d9edf7; padding: 10px; border-radius: 5px; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>Reset Password</h2>
                </div>
                <div class="content">
                    <p>Halo <strong>'.$user->nama_user.'</strong>,</p>
                    
                    <p>Kami menerima permintaan untuk mereset password akun Anda. Klik tombol di bawah ini untuk melanjutkan proses reset password:</p>
                    
                    <p style="text-align: center;">
                        <a href="'.$reset_link.'" class="button" style="color: white;">Reset Password</a>
                    </p>
                    
                    <p>Atau copy dan paste URL berikut ke browser Anda:</p>
                    <p>'.$reset_link.'</p>
                    
                    <div class="alert">
                        <p>Link reset password ini akan kedaluwarsa dalam 1 jam.</p>
                        <p>Jika Anda tidak meminta reset password, abaikan email ini dan password Anda tidak akan berubah.</p>
                    </div>
                    
                    <p>Terima kasih,<br>Tim Keamanan Sistem</p>
                </div>
                <div class="footer">
                    <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
                </div>
            </div>
        </body>
        </html>
        ';
        
        try {
            $result = send_email($user->email_user, $subject, $message, true);
            
            if (is_array($result) && isset($result['success'])) {
                if ($result['success']) {
                    $this->Log_m->create_log('Berhasil mengirim email reset password ke '.$user->email_user);
                    return true;
                } else {
                    log_message('error', 'Email debug: ' . print_r($result['debug'], true));
                    $this->Log_m->create_log('Gagal mengirim email reset password ke '.$user->email_user);
                    return false;
                }
            } else if ($result) {
                $this->Log_m->create_log('Berhasil mengirim email reset password ke '.$user->email_user);
                return true;
            } else {
                $this->Log_m->create_log('Gagal mengirim email reset password ke '.$user->email_user);
                return false;
            }
        } catch (Exception $e) {
            log_message('error', 'Email exception: ' . $e->getMessage());
            $this->Log_m->create_log('Exception saat mengirim email reset password ke '.$user->email_user);
            return false;
        }
    }

    public function reset_password($token = null)
    {
        if ($token === null) {
            redirect('auth/login');
            return;
        }
        
        // Validate token
        $user = $this->Users_m->get_user_by_reset_token($token);
        
        if (!$user) {
            $this->session->set_flashdata('error', 'Token reset password tidak valid atau telah kedaluwarsa');
            redirect('auth/login');
            return;
        }
        
        $data['token'] = $token;
        $this->load->view('auth/reset_password', $data);
    }

    public function process_reset_password()
    {
        $token = $this->input->post('token');
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
        
        // Validate token
        $user = $this->Users_m->get_user_by_reset_token($token);
        
        if (!$user) {
            $this->session->set_flashdata('error', 'Token reset password tidak valid atau telah kedaluwarsa');
            redirect('auth/login');
            return;
        }
        
        // Validate password
        if (strlen($password) < 8) {
            $this->session->set_flashdata('error', 'Password minimal 8 karakter');
            redirect('auth/reset_password/' . $token);
            return;
        }
        
        if ($password !== $confirm_password) {
            $this->session->set_flashdata('error', 'Konfirmasi password tidak cocok');
            redirect('auth/reset_password/' . $token);
            return;
        }
        
        // Update password
        $this->Users_m->ganti_password($user->id_user, $password);
        
        // Delete token
        $this->Users_m->delete_reset_token($token);
        
        $this->load->model('Log_m');
        $this->Log_m->create_log('Password reset for user ID ' . $user->id_user);
        $this->session->set_flashdata('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
        redirect('auth/login');
    }

    // Process email and telegram notifications from queue
    // This should be called by a cron job, not directly from the web interface
    public function process_notification_queue()
    {
        // Check if this is called from CLI or with proper API key
        if (!$this->input->is_cli_request() && $this->input->get('api_key') !== 'crownjob') {
            show_404();
            return;
        }

        // Load required libraries and helpers
        $this->load->library('email');
        $this->load->helper('telegram');
        $this->load->model('Log_m');

        // Get pending notifications
        $query = $this->db->where('status', 'pending')
            ->limit(20)  // Process in batches
            ->get('notification_queue');
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $notification) {
                $success = false;

                // Process based on notification type
                if ($notification->notification_type == 'login') {
                    // Send email notification
                    if ($notification->email) {
                        $success = $this->send_login_email_from_queue($notification);
                    }
                    
                    // Send telegram notification
                    if ($notification->telegram_chat_id) {
                        telegram_notif_login([
                            'id_user' => $notification->user_id,
                            'username' => $notification->username,
                            'nama_user' => $notification->nama_user,
                            'ip_address' => $notification->ip_address,
                            'platform' => $notification->platform,
                            'browser' => $notification->browser
                        ]);
                    }
                }
                
                // Update notification status
                $this->db->where('id', $notification->id)
                    ->update('notification_queue', [
                        'status' => $success ? 'sent' : 'failed',
                        'processed_at' => date('Y-m-d H:i:s')
                    ]);
            }
        }
    }

    // Process email queue
    // This should be called by a cron job, not directly from the web interface
    public function process_email_queue()
    {
        // Check if this is called from CLI or with proper API key
        if (!$this->input->is_cli_request() && $this->input->get('api_key') !== 'crownjob') {
            show_404();
            return;
        }

        // Load required libraries
        $this->load->library('email');
        $this->load->model('Log_m');

        // Get pending emails
        $query = $this->db->where('status', 'pending')
            ->limit(20)  // Process in batches
            ->get('email_queue');
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $email_item) {
                $success = false;
                $data = json_decode($email_item->data, true);

                // Process based on email type
                if ($email_item->email_type == 'login_notification') {
                    $success = $this->send_login_email_from_queue($email_item);
                }
                // Remove reset_password case from here as we're sending directly now
                
                // Update email status
                $this->db->where('id', $email_item->id)
                    ->update('email_queue', [
                        'status' => $success ? 'sent' : 'failed',
                        'processed_at' => date('Y-m-d H:i:s')
                    ]);
            }
        }
    }

    private function send_login_email_from_queue($notification)
    {
        $subject = 'Notifikasi Login - Sistem';
        
        $message = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
                .header { background-color: #f5f5f5; padding: 10px; border-radius: 5px 5px 0 0; text-align: center; }
                .content { padding: 20px; }
                .footer { background-color: #f5f5f5; padding: 10px; border-radius: 0 0 5px 5px; text-align: center; font-size: 12px; }
                .alert { color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 5px; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>Notifikasi Login</h2>
                </div>
                <div class="content">
                    <p>Halo <strong>'.$notification->nama_user.'</strong>,</p>
                    
                    <p>Kami mendeteksi aktivitas login ke akun Anda dengan detail berikut:</p>
                    
                    <ul>
                        <li><strong>Waktu Login:</strong> '.$notification->login_time.'</li>
                        <li><strong>Alamat IP:</strong> '.$notification->ip_address.'</li>
                        <li><strong>Browser:</strong> '.$notification->browser.'</li>
                        <li><strong>Perangkat:</strong> '.$notification->platform.'</li>
                    </ul>
                    
                    <div class="alert">
                        <p>Jika ini bukan Anda, segera ubah password Anda dan hubungi administrator.</p>
                    </div>
                    
                    <p>Terima kasih,<br>Tim Keamanan Sistem</p>
                </div>
                <div class="footer">
                    <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
                </div>
            </div>
        </body>
        </html>
        ';
        
        try {
            $result = send_email($notification->email, $subject, $message, true);
            
            if (is_array($result) && isset($result['success'])) {
                if ($result['success']) {
                    $this->Log_m->create_log('Berhasil mengirim email notifikasi login ke '.$notification->email);
                    return true;
                } else {
                    log_message('error', 'Email debug: ' . print_r($result['debug'], true));
                    $this->Log_m->create_log('Gagal mengirim email notifikasi login ke '.$notification->email);
                    return false;
                }
            } else if ($result) {
                $this->Log_m->create_log('Berhasil mengirim email notifikasi login ke '.$notification->email);
                return true;
            } else {
                $this->Log_m->create_log('Gagal mengirim email notifikasi login ke '.$notification->email);
                return false;
            }
        } catch (Exception $e) {
            log_message('error', 'Email exception: ' . $e->getMessage());
            $this->Log_m->create_log('Exception saat mengirim email notifikasi login ke '.$notification->email);
            return false;
        }
    }
}