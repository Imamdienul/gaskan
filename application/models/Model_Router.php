<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Router extends CI_Model {

    private $table = 'nas';

    public function __construct() {
        parent::__construct();
        // Tidak perlu memuat koneksi database lain, gunakan default
    }

    public function get_all_routers() {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function get_router_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);

        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    public function add_router($data) {
        $router_data = array(
            'nasname' => $data['ip_address'],
            'shortname' => $data['nama'],
            'type' => 'mikrotik',
            'ports' => $data['port'],
            'secret' => 'rahasia',
            'server' => '',
            'community' => 'public',
            'description' => 'Router Mikrotik: ' . $data['username'] . '|' . $data['password'] . '|' . $data['status']
        );

        $this->db->insert($this->table, $router_data);
        return $this->db->insert_id();
    }

    public function update_router($id, $data) {
        $update_data = array();

        if (isset($data['nama'])) {
            $update_data['shortname'] = $data['nama'];
        }

        if (isset($data['ip_address'])) {
            $update_data['nasname'] = $data['ip_address'];
        }

        if (isset($data['port'])) {
            $update_data['ports'] = $data['port'];
        }

        if (isset($data['username']) || isset($data['password']) || isset($data['status'])) {
            $current_router = $this->get_router_by_id($id);
            $description_parts = $this->parse_router_description($current_router->description);

            $username = $data['username'] ?? $description_parts['username'];
            $password = $data['password'] ?? $description_parts['password'];
            $status   = $data['status']   ?? $description_parts['status'];

            $update_data['description'] = 'Router Mikrotik: ' . $username . '|' . $password . '|' . $status;
        }

        if (!empty($update_data)) {
            $this->db->where('id', $id);
            return $this->db->update($this->table, $update_data);
        }

        return FALSE;
    }

    public function parse_router_description($description) {
        $result = array(
            'username' => 'admin',
            'password' => '',
            'status' => 'disconnected'
        );

        if (preg_match('/Router Mikrotik: (.*?)\|(.*?)\|(.*?)$/', $description, $matches)) {
            $result['username'] = $matches[1] ?? 'admin';
            $result['password'] = $matches[2] ?? '';
            $result['status']   = $matches[3] ?? 'disconnected';
        }

        return $result;
    }

    public function delete_router($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function check_router_connection($ip_address) {
        if (!extension_loaded('snmp')) {
            return FALSE;
        }

        $community = 'public';
        $oid = '1.3.6.1.2.1.1.1.0';
        $timeout = 1000000;
        $retries = 3;

        $snmp_data = @snmp2_get($ip_address, $community, $oid, $timeout, $retries);

        return ($snmp_data !== FALSE);
    }

    public function update_all_router_statuses() {
        $routers = $this->get_all_routers();

        foreach ($routers as $router) {
            $status = $this->check_router_connection($router->nasname) ? 'connected' : 'disconnected';

            $this->db->where('id', $router->id);
            $this->db->update($this->table, array('status' => $status));
        }

        return TRUE;
    }
}
