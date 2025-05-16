<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berlangganan_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all berlangganan with join to customer and registration data
    public function get_all_berlangganan() {
        $this->db->select('b.*, c.fullname, c.phone_customer, rc.jenis_layanan, rc.bandwidth, rc.alamat_pemasangan');
        $this->db->from('berlangganan b');
        $this->db->join('customers c', 'b.id_customer = c.uid_customer', 'left');
        $this->db->join('registrasi_customer rc', 'b.id_registrasi_customer = rc.id_registrasi_customer', 'left');
        $this->db->where('b.status', 'active');
        return $this->db->get()->result();
    }
    
    // Get single berlangganan data
    public function get_berlangganan($id) {
        $this->db->select('b.*, c.fullname, c.phone_customer, rc.jenis_layanan, rc.bandwidth, rc.alamat_pemasangan');
        $this->db->from('berlangganan b');
        $this->db->join('customers c', 'b.id_customer = c.uid_customer', 'left');
        $this->db->join('registrasi_customer rc', 'b.id_registrasi_customer = rc.id_registrasi_customer', 'left');
        $this->db->where('b.id_berlangganan', $id);
        return $this->db->get()->row();
    }
    
    // Get customers not yet subscribed
    public function get_available_customers() {
        $this->db->select('c.uid_customer, c.id_customer, c.fullname, c.phone_customer');
        $this->db->from('customers c');
        $this->db->where('c.deleted', 0);
        // Exclude customers that are already in berlangganan
        $this->db->where_not_in('c.uid_customer', 'SELECT id_customer FROM berlangganan WHERE status = "active"', FALSE);
        return $this->db->get()->result();
    }
    
    // Get registrations not yet subscribed
    public function get_available_registrations() {
        $this->db->select('rc.id_registrasi_customer, rc.nomor_registrasi, rc.nama_lengkap, rc.seluler, rc.jenis_layanan, rc.bandwidth');
        $this->db->from('registrasi_customer rc');
        // Exclude registrations that are already in berlangganan
        $this->db->where_not_in('rc.id_registrasi_customer', 'SELECT id_registrasi_customer FROM berlangganan WHERE status = "active"', FALSE);
        return $this->db->get()->result();
    }
    
    // Add new PPPoE user to berlangganan and radius tables
    public function add_ppoe_user($data) {
        // Begin transaction
        $this->db->trans_start();
        
        // Insert into berlangganan table
        $berlangganan_data = [
            'id_customer' => $data['id_customer'],
            'id_registrasi_customer' => $data['id_registrasi_customer'],
            'username' => $data['username'],
            'password' => $data['password'],
            'ip_address' => $data['ip_address'],
            'status' => 'active',
            'tanggal_aktivasi' => date('Y-m-d'),
            'tanggal_expired' => date('Y-m-d', strtotime('+1 year')),
            'created_by' => $this->session->userdata('user_id')
        ];
        
        $this->db->insert('berlangganan', $berlangganan_data);
        
        // Insert into radcheck for authentication
        $radcheck_data = [
            'username' => $data['username'],
            'attribute' => 'Cleartext-Password',
            'op' => ':=',
            'value' => $data['password']
        ];
        
        $this->db->insert('radcheck', $radcheck_data);
        
        // If IP address is provided, set up radreply entries
        if (!empty($data['ip_address'])) {
            $radreply_data = [
                [
                    'username' => $data['username'],
                    'attribute' => 'Framed-IP-Address',
                    'op' => ':=',
                    'value' => $data['ip_address']
                ],
                [
                    'username' => $data['username'],
                    'attribute' => 'Framed-IP-Netmask',
                    'op' => ':=',
                    'value' => '255.255.255.255'
                ],
                [
                    'username' => $data['username'],
                    'attribute' => 'Framed-Route',
                    'op' => ':=',
                    'value' => substr($data['ip_address'], 0, strrpos($data['ip_address'], '.')) . '.1/32'
                ],
                [
                    'username' => $data['username'],
                    'attribute' => 'Framed-Protocol',
                    'op' => ':=',
                    'value' => 'PPP'
                ],
                [
                    'username' => $data['username'],
                    'attribute' => 'Service-Type',
                    'op' => ':=',
                    'value' => 'Framed-User'
                ]
            ];
            
            foreach ($radreply_data as $reply) {
                $this->db->insert('radreply', $reply);
            }
        }
        
        // Complete transaction
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
    
    // Update PPPoE user
    public function update_ppoe_user($id, $data) {
        // Begin transaction
        $this->db->trans_start();
        
        $berlangganan = $this->get_berlangganan($id);
        $old_username = $berlangganan->username;
        
        // Update berlangganan table
        $berlangganan_data = [
            'username' => $data['username'],
            'password' => $data['password'],
            'ip_address' => $data['ip_address'],
            'status' => $data['status']
        ];
        
        $this->db->where('id_berlangganan', $id);
        $this->db->update('berlangganan', $berlangganan_data);
        
        // Delete old entries from radius tables
        $this->db->where('username', $old_username);
        $this->db->delete('radcheck');
        
        $this->db->where('username', $old_username);
        $this->db->delete('radreply');
        
        // If status is active, insert new radius entries
        if ($data['status'] == 'active') {
            // Insert into radcheck for authentication
            $radcheck_data = [
                'username' => $data['username'],
                'attribute' => 'Cleartext-Password',
                'op' => ':=',
                'value' => $data['password']
            ];
            
            $this->db->insert('radcheck', $radcheck_data);
            
            // If IP address is provided, set up radreply entries
            if (!empty($data['ip_address'])) {
                $radreply_data = [
                    [
                        'username' => $data['username'],
                        'attribute' => 'Framed-IP-Address',
                        'op' => ':=',
                        'value' => $data['ip_address']
                    ],
                    [
                        'username' => $data['username'],
                        'attribute' => 'Framed-IP-Netmask',
                        'op' => ':=',
                        'value' => '255.255.255.255'
                    ],
                    [
                        'username' => $data['username'],
                        'attribute' => 'Framed-Route',
                        'op' => ':=',
                        'value' => substr($data['ip_address'], 0, strrpos($data['ip_address'], '.')) . '.1/32'
                    ],
                    [
                        'username' => $data['username'],
                        'attribute' => 'Framed-Protocol',
                        'op' => ':=',
                        'value' => 'PPP'
                    ],
                    [
                        'username' => $data['username'],
                        'attribute' => 'Service-Type',
                        'op' => ':=',
                        'value' => 'Framed-User'
                    ]
                ];
                
                foreach ($radreply_data as $reply) {
                    $this->db->insert('radreply', $reply);
                }
            }
        }
        
        // Complete transaction
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
    
    // Delete PPPoE user (set status to inactive and remove from radius tables)
    public function delete_ppoe_user($id) {
        // Begin transaction
        $this->db->trans_start();
        
        $berlangganan = $this->get_berlangganan($id);
        
        // Set status to inactive
        $this->db->where('id_berlangganan', $id);
        $this->db->update('berlangganan', ['status' => 'inactive']);
        
        // Delete from radius tables
        $this->db->where('username', $berlangganan->username);
        $this->db->delete('radcheck');
        
        $this->db->where('username', $berlangganan->username);
        $this->db->delete('radreply');
        
        // Complete transaction
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
    
    // Get customer by ID
    public function get_customer($id) {
        $this->db->where('uid_customer', $id);
        return $this->db->get('customers')->row();
    }
    
    // Get registration by ID
    public function get_registration($id) {
        $this->db->where('id_registrasi_customer', $id);
        return $this->db->get('registrasi_customer')->row();
    }
    
    // Generate next available IP address
    public function generate_next_ip() {
        // Default subnet for PPPoE
        $subnet = '192.168.90';
        
        // Find the highest used IP in the subnet
        $this->db->select('value');
        $this->db->from('radreply');
        $this->db->where('attribute', 'Framed-IP-Address');
        $this->db->like('value', $subnet, 'after');
        $this->db->order_by('INET_ATON(value)', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $last_ip = $query->row()->value;
            $last_octet = intval(substr($last_ip, strrpos($last_ip, '.') + 1));
            $next_octet = $last_octet + 1;
            
            // Make sure we don't exceed valid octet range
            if ($next_octet > 254) {
                return null; // IP pool exhausted
            }
            
            return $subnet . '.' . $next_octet;
        }
        
        // No IPs assigned yet, start from .2 (.1 is typically gateway)
        return $subnet . '.2';
    }
    
    // Check if username already exists
    public function check_username_exists($username, $id = null) {
        $this->db->where('username', $username);
        if ($id) {
            $this->db->where('id_berlangganan !=', $id);
        }
        return $this->db->get('berlangganan')->num_rows() > 0;
    }
    
    // Check if IP already assigned
    public function check_ip_exists($ip, $id = null) {
        $this->db->where('ip_address', $ip);
        if ($id) {
            $this->db->where('id_berlangganan !=', $id);
        }
        return $this->db->get('berlangganan')->num_rows() > 0;
    }
}