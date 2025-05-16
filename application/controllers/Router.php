<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Router extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Router_model');
        $this->load->library('mikrotik');
    }

    public function index() {
        $data['routers'] = $this->Router_model->get_all();
        $this->template->load('shared/index', 'router/index', $data);
    }

    public function add() {
        if ($_POST) {
            $input = $this->input->post();
            $data = [
                'nama_router' => $input['nama_router'],
                'ip_public' => $input['ip_public'],
                'username' => $input['username'],
                'password' => $input['password'],
                'port' => $input['port']
            ];
            $this->Router_model->insert($data);
            redirect('router');
        }
        $this->template->load('shared/index', 'router/form_add');
    }

    public function edit($id) {
        $router = $this->Router_model->get_by_id($id);
        if (!$router) show_404();

        if ($_POST) {
            $input = $this->input->post();
            $data = [
                'nama_router' => $input['nama_router'],
                'ip_public' => $input['ip_public'],
                'username' => $input['username'],
                'password' => $input['password'],
                'port' => $input['port']
            ];
            $this->Router_model->update($id, $data);
            redirect('router');
        }

        $data['router'] = $router;
        $this->template->load('shared/index', 'router/form_edit', $data);
    }
    public function detail($id) {
        $router = $this->Router_model->get_by_id($id);
        if (!$router) show_404();
    
        $this->load->library('mikrotik');
        $API = $this->mikrotik;
    
        $status = 'Down';
        $monitor = [];
    
        if ($API->connect($router->ip_public, $router->username, $router->password, $router->port)) {
            $status = 'Up';
    
            // Ambil data monitoring
            $identity = $API->comm('/system/identity/print');
            $resource = $API->comm('/system/resource/print');
            $uptime = $resource[0]['uptime'];
            $cpu = $resource[0]['cpu-load'];
            $free_memory = $resource[0]['free-memory'];
            $total_memory = $resource[0]['total-memory'];
            $ram_usage = round((($total_memory - $free_memory) / $total_memory) * 100, 2);
            $monitor = [
                'identity' => $identity[0]['name'],
                'uptime' => $uptime,
                'cpu_load' => $cpu,
                'ram_usage' => $ram_usage,
            ];
    
            // Ambil traffic interface ether1
            $traffic = $API->comm('/interface/monitor-traffic', [
                'interface' => 'ether1',
                'once' => ''
            ]);
            $monitor['rx'] = round($traffic[0]['rx-bits-per-second'] / 1024, 2); // KB/s
            $monitor['tx'] = round($traffic[0]['tx-bits-per-second'] / 1024, 2);
    
            $API->disconnect();
        }
    
        $data = [
            'router' => $router,
            'status' => $status,
            'monitor' => $monitor,
        ];
    
        $this->template->load('shared/index', 'router/detail', $data);
    }
    public function get_traffic() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $router = $this->Router_model->get_by_id($id);
            
            if (!$router) {
                echo json_encode(['status' => 'error', 'message' => 'Router not found']);
                return;
            }
            
            $this->load->library('mikrotik');
            $API = $this->mikrotik;
            
            $data = [
                'rx' => 0,
                'tx' => 0
            ];
            
            if ($API->connect($router->ip_public, $router->username, $router->password, $router->port)) {
                $traffic = $API->comm('/interface/monitor-traffic', [
                    'interface' => 'ether1',
                    'once' => ''
                ]);
                
                if (isset($traffic[0])) {
                    $data['rx'] = round($traffic[0]['rx-bits-per-second'] / 1024, 2); // KB/s
                    $data['tx'] = round($traffic[0]['tx-bits-per-second'] / 1024, 2); // KB/s
                }
                
                $API->disconnect();
            }
            
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            show_404();
        }
    }
    
    public function get_interfaces() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $router = $this->Router_model->get_by_id($id);
            
            if (!$router) {
                echo json_encode(['status' => 'error', 'message' => 'Router not found']);
                return;
            }
            
            $this->load->library('mikrotik');
            $API = $this->mikrotik;
            
            $interfaces = [];
            
            if ($API->connect($router->ip_public, $router->username, $router->password, $router->port)) {
                // Mengambil data interface
                $interface_list = $API->comm('/interface/print');
                
                foreach ($interface_list as $interface) {
                    // Ambil traffic untuk interface ini
                    $stats = $API->comm('/interface/monitor-traffic', [
                        'interface' => $interface['name'],
                        'once' => ''
                    ]);
                    
                    $rx_byte = isset($stats[0]['rx-bits-per-second']) ? $this->format_bytes($stats[0]['rx-bits-per-second'] / 8) : '0 B';
                    $tx_byte = isset($stats[0]['tx-bits-per-second']) ? $this->format_bytes($stats[0]['tx-bits-per-second'] / 8) : '0 B';
                    
                    $interfaces[] = [
                        'name' => $interface['name'],
                        'type' => isset($interface['type']) ? $interface['type'] : 'unknown',
                        'running' => isset($interface['running']) ? $interface['running'] : false,
                        'rx_byte' => $rx_byte,
                        'tx_byte' => $tx_byte
                    ];
                }
                
                $API->disconnect();
            }
            
            echo json_encode(['status' => 'success', 'data' => $interfaces]);
        } else {
            show_404();
        }
    }
    
    public function get_resources() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $router = $this->Router_model->get_by_id($id);
            
            if (!$router) {
                echo json_encode(['status' => 'error', 'message' => 'Router not found']);
                return;
            }
            
            $this->load->library('mikrotik');
            $API = $this->mikrotik;
            
            $data = [
                'cpu_load' => 0,
                'ram_usage' => 0,
                'disk_usage' => 0,
                'free_disk' => 0,
                'total_disk' => 0
            ];
            
            if ($API->connect($router->ip_public, $router->username, $router->password, $router->port)) {
                // Mengambil data resource
                $resource = $API->comm('/system/resource/print');
                
                if (isset($resource[0])) {
                    $free_memory = $resource[0]['free-memory'];
                    $total_memory = $resource[0]['total-memory'];
                    
                    $data['cpu_load'] = $resource[0]['cpu-load'];
                    $data['ram_usage'] = round((($total_memory - $free_memory) / $total_memory) * 100, 2);
                    
                    // Mengambil data disk
                    if (isset($resource[0]['free-hdd-space']) && isset($resource[0]['total-hdd-space'])) {
                        $free_disk = $resource[0]['free-hdd-space'];
                        $total_disk = $resource[0]['total-hdd-space'];
                        
                        $data['disk_usage'] = round((($total_disk - $free_disk) / $total_disk) * 100, 2);
                        $data['free_disk'] = round($free_disk / (1024 * 1024), 2); // MB
                        $data['total_disk'] = round($total_disk / (1024 * 1024), 2); // MB
                    }
                }
                
                // SNMP monitoring - tambahkan jika RouterOS API mendukung
                try {
                    // Coba ambil data SNMP jika tersedia
                    $health = $API->comm('/system/health/print');
                    if (!empty($health)) {
                        // Tambahkan data suhu CPU jika tersedia
                        if (isset($health[0]['temperature'])) {
                            $data['cpu_temperature'] = $health[0]['temperature'];
                        }
                        
                        // Tambahkan data voltage jika tersedia
                        if (isset($health[0]['voltage'])) {
                            $data['voltage'] = $health[0]['voltage'];
                        }
                    }
                } catch (Exception $e) {
                    // Abaikan error jika SNMP tidak didukung
                }
                
                $API->disconnect();
            }
            
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            show_404();
        }
    }
    
    public function get_snmp_data() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $router = $this->Router_model->get_by_id($id);
            
            if (!$router) {
                echo json_encode(['status' => 'error', 'message' => 'Router not found']);
                return;
            }
            
            // Pastikan snmp extension PHP sudah terinstall
            if (!extension_loaded('snmp')) {
                echo json_encode(['status' => 'error', 'message' => 'SNMP extension not loaded']);
                return;
            }
            
            $data = [];
            
            try {
                // Set timeout dan retry
                snmp_set_quick_print(true);
                snmp_set_valueretrieval(SNMP_VALUE_PLAIN);
                
                // Ambil SNMP data (ganti community dengan yang sesuai di router)
                $community = 'public'; // Default SNMP community
                
                // System info
                $data['sysDescr'] = @snmpget($router->ip_public, $community, '1.3.6.1.2.1.1.1.0');
                $data['sysUpTime'] = @snmpget($router->ip_public, $community, '1.3.6.1.2.1.1.3.0');
                $data['sysName'] = @snmpget($router->ip_public, $community, '1.3.6.1.2.1.1.5.0');
                
                // Interface stats
                $data['interfaces'] = [];
                $ifNumber = @snmpget($router->ip_public, $community, '1.3.6.1.2.1.2.1.0');
                
                if ($ifNumber) {
                    $ifNumber = (int)$ifNumber;
                    
                    for ($i = 1; $i <= $ifNumber; $i++) {
                        $ifName = @snmpget($router->ip_public, $community, "1.3.6.1.2.1.2.2.1.2.$i");
                        
                        if ($ifName) {
                            $ifType = @snmpget($router->ip_public, $community, "1.3.6.1.2.1.2.2.1.3.$i");
                            $ifMtu = @snmpget($router->ip_public, $community, "1.3.6.1.2.1.2.2.1.4.$i");
                            $ifSpeed = @snmpget($router->ip_public, $community, "1.3.6.1.2.1.2.2.1.5.$i");
                            $ifAdminStatus = @snmpget($router->ip_public, $community, "1.3.6.1.2.1.2.2.1.7.$i");
                            $ifOperStatus = @snmpget($router->ip_public, $community, "1.3.6.1.2.1.2.2.1.8.$i");
                            $ifInOctets = @snmpget($router->ip_public, $community, "1.3.6.1.2.1.2.2.1.10.$i");
                            $ifOutOctets = @snmpget($router->ip_public, $community, "1.3.6.1.2.1.2.2.1.16.$i");
                            
                            $data['interfaces'][] = [
                                'name' => $ifName,
                                'type' => $ifType,
                                'mtu' => $ifMtu,
                                'speed' => $this->format_bytes((int)$ifSpeed / 8) . '/s',
                                'admin_status' => ((int)$ifAdminStatus == 1) ? 'up' : 'down',
                                'oper_status' => ((int)$ifOperStatus == 1) ? 'up' : 'down',
                                'in_octets' => $this->format_bytes((int)$ifInOctets),
                                'out_octets' => $this->format_bytes((int)$ifOutOctets)
                            ];
                        }
                    }
                }
                
                echo json_encode(['status' => 'success', 'data' => $data]);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            show_404();
        }
    }
    
    // Helper function untuk konversi bytes ke format yang lebih mudah dibaca
    private function format_bytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    
    // Fungsi untuk menampilkan grafik monitoring per router
    public function monitoring($id) {
        $router = $this->Router_model->get_by_id($id);
        if (!$router) show_404();
        
        $data = [
            'router' => $router,
            'title' => 'Monitoring Router: ' . $router->nama_router
        ];
        
        $this->template->load('shared/index', 'router/monitoring', $data);
    }
    
    // Fungsi untuk download laporan penggunaan resource
    public function download_report($id, $type = 'pdf') {
        $router = $this->Router_model->get_by_id($id);
        if (!$router) show_404();
        
        $this->load->library('mikrotik');
        $API = $this->mikrotik;
        
        $data = [
            'router' => $router,
            'status' => 'Down',
            'resource' => [],
            'interfaces' => [],
            'traffic' => []
        ];
        
        if ($API->connect($router->ip_public, $router->username, $router->password, $router->port)) {
            $data['status'] = 'Up';
            
            // Ambil resource info
            $resource = $API->comm('/system/resource/print');
            if (!empty($resource)) {
                $data['resource'] = $resource[0];
            }
            
            // Ambil interface info
            $interfaces = $API->comm('/interface/print');
            $data['interfaces'] = $interfaces;
            
            // Ambil traffic info untuk beberapa interface utama
            $traffic_data = [];
            foreach ($interfaces as $interface) {
                if (in_array($interface['name'], ['ether1', 'ether2', 'wlan1'])) {
                    $traffic = $API->comm('/interface/monitor-traffic', [
                        'interface' => $interface['name'],
                        'once' => ''
                    ]);
                    
                    if (isset($traffic[0])) {
                        $traffic_data[$interface['name']] = [
                            'rx' => round($traffic[0]['rx-bits-per-second'] / 1024, 2),
                            'tx' => round($traffic[0]['tx-bits-per-second'] / 1024, 2)
                        ];
                    }
                }
            }
            $data['traffic'] = $traffic_data;
            
            $API->disconnect();
        }
        
        // Load library untuk generate PDF atau Excel
        if ($type == 'pdf') {
            $this->load->library('pdf');
            $html = $this->load->view('router/report_pdf', $data, true);
            $this->pdf->loadHtml($html);
            $this->pdf->setPaper('A4', 'portrait');
            $this->pdf->render();
            $this->pdf->stream("router_report_" . $router->nama_router . ".pdf", ['Attachment' => 1]);
        } else {
            // Excel report
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Router Report');
            
            // Set header
            $this->excel->getActiveSheet()->setCellValue('A1', 'Router Report: ' . $router->nama_router);
            $this->excel->getActiveSheet()->setCellValue('A3', 'Status: ' . $data['status']);
            
            // Set resource info
            if ($data['status'] == 'Up') {
                $row = 5;
                $this->excel->getActiveSheet()->setCellValue('A' . $row, 'Resource Information');
                $row++;
                $this->excel->getActiveSheet()->setCellValue('A' . $row, 'CPU Load');
                $this->excel->getActiveSheet()->setCellValue('B' . $row, $data['resource']['cpu-load'] . '%');
                $row++;
                $this->excel->getActiveSheet()->setCellValue('A' . $row, 'Free Memory');
                $this->excel->getActiveSheet()->setCellValue('B' . $row, $this->format_bytes($data['resource']['free-memory']));
                $row++;
                $this->excel->getActiveSheet()->setCellValue('A' . $row, 'Total Memory');
                $this->excel->getActiveSheet()->setCellValue('B' . $row, $this->format_bytes($data['resource']['total-memory']));
                $row++;
                $this->excel->getActiveSheet()->setCellValue('A' . $row, 'Uptime');
                $this->excel->getActiveSheet()->setCellValue('B' . $row, $data['resource']['uptime']);
                
                // Set interface info
                $row += 2;
                $this->excel->getActiveSheet()->setCellValue('A' . $row, 'Interface Information');
                $row++;
                $this->excel->getActiveSheet()->setCellValue('A' . $row, 'Name');
                $this->excel->getActiveSheet()->setCellValue('B' . $row, 'Type');
                $this->excel->getActiveSheet()->setCellValue('C' . $row, 'Status');
                $row++;
                
                foreach ($data['interfaces'] as $interface) {
                    $this->excel->getActiveSheet()->setCellValue('A' . $row, $interface['name']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $row, isset($interface['type']) ? $interface['type'] : 'unknown');
                    $this->excel->getActiveSheet()->setCellValue('C' . $row, isset($interface['running']) && $interface['running'] ? 'Up' : 'Down');
                    $row++;
                }
            }
            
            $filename = "router_report_" . $router->nama_router . ".xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
            $writer->save('php://output');
        }
    }
    
}
