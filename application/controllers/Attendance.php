<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {
    private $current_time;
    private $current_day;
    private $telegram_token = "6259502863:AAEsTD1linSz1FbX4Hs7SH5U238u_ftIRZU";
    private $grace_period = 15; 

    public function __construct() {
        parent::__construct();
        $this->load->model(['attendance_model', 'employee_schedule_model']);
        $this->load->helper('telegram');
        $this->current_time = date("H:i");
        $this->current_day = date("l");
        $this->load->helper(['url', 'form', 'date']);
        $this->load->library(['session', 'form_validation']);
    }

    public function check_attendance() {
        header('Content-Type: application/json');
        
        $fingerprint_id = $this->input->post('fingerprint_id');
        
        if (!$fingerprint_id) {
            $this->send_response('error', 'Invalid input');
            return;
        }

        $user = $this->attendance_model->check_fingerprint_id($fingerprint_id);
        $operational = $this->attendance_model->check_operational_time($this->current_day, $this->current_time);
        $late_operational = $this->attendance_model->check_late_time($this->current_day, $this->current_time, $this->grace_period);

        if (!$user) {
            $this->send_response('error', 'ID Tidak Valid');
            return;
        }


        if (!$operational && !$late_operational) {
            $this->handle_non_operational_time();
            return;
        }


        $status = 0;
        $keterangan = 'keluar';
        
        if ($operational && $operational->keterangan == 'masuk') {
            $status = 1;
            $keterangan = 'masuk';
        } elseif ($late_operational && $late_operational->keterangan == 'masuk') {
            $status = 3; 
            $keterangan = 'telat';
        } elseif ($operational && $operational->keterangan == 'keluar') {
            $status = 0;
            $keterangan = 'keluar';
        }

        $attendance_data = [
            'id_user' => $user->id_user,
            'timestamp' => date('Y-m-d H:i:s'),
            'status' => $status
        ];

        $save_result = $this->attendance_model->save_attendance($attendance_data);
        
        $message = $save_result ? 
            sprintf('%s: %s (%s)', $keterangan, $user->nama_user, date('H:i')) :
            'Sudah Tercatat';

        if ($save_result && $user->chat_id != '0') {
            $this->send_attendance_notification($user, $keterangan);
        }

        $this->send_response(
            $save_result ? 'success' : 'error',
            $message
        );
    }

    private function send_attendance_notification($user, $status) {
        $ch = curl_init();
        
        if ($status == 'masuk') {
            $message = "🏢 SELAMAT DATANG DI KANTOR GISAKA.\n\n";
            $message .= "NAMA: {$user->nama_user}\n";
            $message .= "NIK: {$user->nik}\n";
            $message .= "Waktu: " . date("H:i") . "\n\n";
            $message .= "TERIMAKASIH TELAH MASUK TEPAT WAKTU.\n\n";
            $message .= "admin gas (Gisaka Automation System)";
        } elseif ($status == 'telat') {
            $message = "🏢 SELAMAT DATANG DI KANTOR GISAKA.\n\n";
            $message .= "NAMA: {$user->nama_user}\n";
            $message .= "NIK: {$user->nik}\n";
            $message .= "Waktu: " . date("H:i") . "\n\n";
            $message .= "Mohon diperhatikan bahwa Anda terlambat masuk kantor hari ini.\n";
            $message .= "Keterlambatan dapat berpengaruh pada kompensasi yang Anda terima.\n";
            $message .= "Terima kasih atas pengertian dan kerja sama Anda.\n\n";
            $message .= "admin gas (Gisaka Automation System)";
        } else {
            $message = "🏢 TERIMAKASIH ATAS KERJASAMANYA HARI INI.\n\n";
            $message .= "NAMA: {$user->nama_user}\n";
            $message .= "NIK: {$user->nik}\n";
            $message .= "Waktu Pulang: " . date("H:i") . "\n\n";
            $message .= "HATI HATI DI JALAN BY BY.\n\n";
            $message .= "admin gas (Gisaka Automation System)";
        }

        $txt = urlencode($message);
        $apiURL = "https://api.telegram.org/bot{$this->telegram_token}";
        
        curl_setopt($ch, CURLOPT_URL, $apiURL . "/sendmessage?chat_id={$user->chat_id}/&text=$txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $output = curl_exec($ch);
        
        if ($output === FALSE) {
            log_message('error', 'Failed to send Telegram notification to chat_id: ' . $user->chat_id);
        }
        
        curl_close($ch);
    }

    private function handle_non_operational_time() {
        $schedule = $this->attendance_model->get_operational_hours($this->current_day);
        
        if (empty($schedule)) {
            $this->send_response('error', 'Hari Ini Libur');
            return;
        }

        $times = array_map(function($s) {
            return $s->keterangan . ': ' . $s->waktu_operasional;
        }, $schedule);

        $this->send_response('error', 'Diluar Jam: ' . implode(', ', $times));
    }

    private function send_response($status, $message) {
        echo json_encode(compact('status', 'message'));
    }
    
    // Modify the recap method in the Attendance controller

public function recap() {
    // Calculate the start of the current week
    $current_week_start = date('Y-m-d', strtotime('this week monday'));
    $current_date = date('Y-m-d'); // Today's date
    
    // Use GET parameters if provided, otherwise use current week start and today
    $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : $current_week_start;
    $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : $current_date;
    
    $data['users'] = $this->attendance_model->get_all_users();
    $data['dates'] = $this->generate_date_range($start_date, $end_date);
    
    // Get attendance champions and frequently late employee
    $data['attendance_champions'] = $this->attendance_model->get_attendance_champions($start_date, $end_date, 3);
    $data['frequently_late'] = $this->attendance_model->get_frequently_late_employee($start_date, $end_date);
    
    $data['attendance_matrix'] = [];
    
    foreach ($data['users'] as $user) {
        $user_attendance = [];
        foreach ($data['dates'] as $date) {
            $formatted_date = $date->format('Y-m-d');
            
            // Check if the employee works on this day
            if (!$this->employee_schedule_model->is_user_working($user['id_user'], $formatted_date)) {
                $user_attendance[$formatted_date] = [
                    'status' => 'Libur',
                    'times' => []
                ];
            } else {
                // If working day, continue with regular attendance check
                $user_attendance[$formatted_date] = $this->attendance_model->get_user_attendance_status(
                    $user['id_user'], 
                    $formatted_date
                );
            }
        }
        $data['attendance_matrix'][$user['id_user']] = $user_attendance;
    }
    
    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;
    
    $data['title'] = 'Rekap Kehadiran';
    $this->template->load('shared/index', 'recap/index', $data);
}
    
    public function export() {
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : date('Y-m-01');
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : date('Y-m-d');
        
        $users = $this->attendance_model->get_all_users();
        $dates = $this->generate_date_range($start_date, $end_date);
        
        $csv_data = [];
        
        $header = ['No', 'Nama'];
        foreach ($dates as $date) {
            $header[] = $date->format('Y-m-d');
        }
        $csv_data[] = $header;
        
        $no = 1;
        foreach ($users as $user) {
            $row = [$no++, $user['nama_user']];
            foreach ($dates as $date) {
                $formatted_date = $date->format('Y-m-d');
                $row[] = $this->attendance_model->get_user_attendance_status(
                    $user['id_user'], 
                    $formatted_date
                );
            }
            $csv_data[] = $row;
        }
        
        $filename = 'rekap_kehadiran_' . $start_date . '_' . $end_date . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        foreach ($csv_data as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit;
    }
    
    private function generate_date_range($start_date, $end_date) {
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $end->modify('+1 day');
        
        $interval = new DateInterval('P1D');
        $date_range = new DatePeriod($start, $interval, $end);
        
        return iterator_to_array($date_range);
    }
}