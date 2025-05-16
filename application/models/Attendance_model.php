<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Attendance_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
   
    public function check_fingerprint_id($fingerprint_id) {
        $this->db->select('f.*, u.nama_user, u.chat_id, u.nik');
        $this->db->from('fingerprint_data f');
        $this->db->join('users u', 'f.id_user = u.id_user');
        $this->db->where('f.fingerprint_id', $fingerprint_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function check_operational_time($day, $current_time) {
        // Get the time slots for the current day
        $this->db->where('day', $day);
        $query = $this->db->get('waktu_operasional');
        
        if ($query->num_rows() == 0) {
            return false;
        }

        foreach ($query->result() as $row) {

            list($start_time, $end_time) = explode('-', $row->waktu_operasional);
            
          
            $current_minutes = $this->time_to_minutes($current_time);
            $start_minutes = $this->time_to_minutes($start_time);
            $end_minutes = $this->time_to_minutes($end_time);
            
            // Check if current time falls within the range
            if ($current_minutes >= $start_minutes && $current_minutes <= $end_minutes) {
                return $row;
            }
        }
        
        return false;
    }

    public function check_late_time($day, $current_time, $grace_period) {
        // Get the time slots for the current day
        $this->db->where('day', $day);
        $this->db->where('keterangan', 'masuk');
        $query = $this->db->get('waktu_operasional');
        
        if ($query->num_rows() == 0) {
            return false;
        }

        foreach ($query->result() as $row) {
            // Split the time range
            list($start_time, $end_time) = explode('-', $row->waktu_operasional);
            
            // Convert all times to minutes since midnight for easier comparison
            $current_minutes = $this->time_to_minutes($current_time);
            $end_minutes = $this->time_to_minutes($end_time);
            $grace_end_minutes = $end_minutes + $grace_period;
            
            // Check if current time falls within the grace period after end time
            if ($current_minutes > $end_minutes && $current_minutes <= $grace_end_minutes) {
                return $row;
            }
        }
        
        return false;
    }

    private function time_to_minutes($time) {
        list($hours, $minutes) = explode(':', $time);
        return ($hours * 60) + $minutes;
    }

    public function get_operational_hours($day) {
        $this->db->where('day', $day);
        $query = $this->db->get('waktu_operasional');
        return $query->result();
    }

    public function save_attendance($data) {
        // Check if user already has attendance record for the day and status
        $this->db->where('id_user', $data['id_user']);
        $this->db->where('DATE(timestamp)', date('Y-m-d'));
        $this->db->where('status', $data['status']);
        $existing = $this->db->get('attendance');

        if ($existing->num_rows() > 0) {
            return false;
        }

        return $this->db->insert('attendance', $data);
    }
    
    public function get_attendance_by_date_range($start_date, $end_date) {
        $this->db->select('a.*, u.nama_user');
        $this->db->from('attendance a');
        $this->db->join('users u', 'a.id_user = u.id_user');
        $this->db->where('DATE(a.timestamp) >=', $start_date);
        $this->db->where('DATE(a.timestamp) <=', $end_date);
        $this->db->order_by('u.nama_user ASC, a.timestamp ASC');
        
        return $this->db->get()->result_array();
    }
    
    public function get_all_users() {
        $this->db->select('id_user, nama_user');
        $this->db->from('users');
        $this->db->where('deleted', 0);
        $this->db->where('status_user', 1);
        $this->db->order_by('nama_user', 'ASC');
        
        return $this->db->get()->result_array();
    }
    
    public function get_user_attendance_status($user_id, $date) {
    $this->load->model('employee_schedule_model');
    
    $is_working = $this->employee_schedule_model->is_user_working($user_id, $date);

    if (!$is_working) {
        $schedule = $this->employee_schedule_model->get_user_day_schedule(
            $user_id, 
            date('l', strtotime($date))
        );
        
        return !empty($schedule['custom_holiday_reason']) 
            ? 'Libur (' . $schedule['custom_holiday_reason'] . ')' 
            : 'Libur';
    }
    
    $this->db->select('status, timestamp');
    $this->db->from('attendance');
    $this->db->where('id_user', $user_id);
    $this->db->where('DATE(timestamp)', $date);
    $this->db->order_by('timestamp', 'ASC');
    
    $query = $this->db->get();
    $results = $query->result_array();
    
    if (empty($results)) {
        return [
            'status' => '',
            'times' => []
        ]; 
    }
    
    $statuses = array_column($results, 'status');
    $times = [];
    
    foreach ($results as $result) {
        $time_str = date('H:i', strtotime($result['timestamp']));
        if ($result['status'] == 1) {
            $times['masuk'] = $time_str;
        } else if ($result['status'] == 0) {
            $times['keluar'] = $time_str;
        } else if ($result['status'] == 3) {
            $times['telat'] = $time_str;
        }
    }
    
    $status = '';
    if (in_array(3, $statuses) && in_array(0, $statuses)) {
        $status = 'telat-keluar';
    } else if (in_array(3, $statuses)) {
        $status = 'telat';
    } else if (in_array(1, $statuses) && in_array(0, $statuses)) {
        $status = 'masuk-keluar';
    } else if (in_array(1, $statuses)) {
        $status = 'masuk';
    } else if (in_array(0, $statuses)) {
        $status = 'keluar';
    }
    
    return [
        'status' => $status,
        'times' => $times
    ];
}
// Add these new functions to the Attendance_model class

public function get_attendance_champions($start_date, $end_date, $limit = 3) {
    // Get all users
    $users = $this->get_all_users();
    $result = [];
    
    foreach ($users as $user) {
        $perfect_days = 0;
        $working_days = 0;
        
        // Get all dates in the range
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $end->modify('+1 day');
        
        $interval = new DateInterval('P1D');
        $date_range = new DatePeriod($start, $interval, $end);
        
        foreach ($date_range as $date) {
            $formatted_date = $date->format('Y-m-d');
            
            // Skip if not a working day
            if (!$this->employee_schedule_model->is_user_working($user['id_user'], $formatted_date)) {
                continue;
            }
            
            $working_days++;
            
            // Check attendance status
            $attendance = $this->get_user_attendance_status($user['id_user'], $formatted_date);
            if (is_array($attendance) && ($attendance['status'] == 'masuk-keluar')) {
                $perfect_days++;
            }
        }
        
        // Calculate attendance score (percentage of perfect days)
        $score = $working_days > 0 ? ($perfect_days / $working_days) * 100 : 0;
        
        $result[] = [
            'id_user' => $user['id_user'],
            'nama_user' => $user['nama_user'],
            'perfect_days' => $perfect_days,
            'working_days' => $working_days,
            'score' => $score,
            'percentage' => round($score, 1)
        ];
    }
    
    // Sort by score (descending)
    usort($result, function($a, $b) {
        if ($a['score'] == $b['score']) {
            return $a['perfect_days'] < $b['perfect_days'] ? 1 : -1; // If same score, more perfect days wins
        }
        return $a['score'] < $b['score'] ? 1 : -1;
    });
    
    // Return only the top performers
    return array_slice($result, 0, $limit);
}

public function get_frequently_late_employee($start_date, $end_date) {
    // Get all users
    $users = $this->get_all_users();
    $result = [];
    
    foreach ($users as $user) {
        $late_days = 0;
        $working_days = 0;
        
        // Get all dates in the range
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $end->modify('+1 day');
        
        $interval = new DateInterval('P1D');
        $date_range = new DatePeriod($start, $interval, $end);
        
        foreach ($date_range as $date) {
            $formatted_date = $date->format('Y-m-d');
            
            // Skip if not a working day
            if (!$this->employee_schedule_model->is_user_working($user['id_user'], $formatted_date)) {
                continue;
            }
            
            $working_days++;
            
            // Check attendance status
            $attendance = $this->get_user_attendance_status($user['id_user'], $formatted_date);
            if (is_array($attendance) && (strpos($attendance['status'], 'telat') !== false)) {
                $late_days++;
            }
        }
        
        // Calculate lateness score
        $late_percentage = $working_days > 0 ? ($late_days / $working_days) * 100 : 0;
        
        if ($late_days > 0) {
            $result[] = [
                'id_user' => $user['id_user'],
                'nama_user' => $user['nama_user'],
                'late_days' => $late_days,
                'working_days' => $working_days,
                'late_percentage' => round($late_percentage, 1)
            ];
        }
    }
    
    // Sort by late_days (descending)
    usort($result, function($a, $b) {
        if ($a['late_days'] == $b['late_days']) {
            return $a['late_percentage'] < $b['late_percentage'] ? 1 : -1;
        }
        return $a['late_days'] < $b['late_days'] ? 1 : -1;
    });
    
    // Return the most frequently late employee
    return !empty($result) ? $result[0] : null;
}
}