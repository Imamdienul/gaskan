<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_schedule_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function get_user_schedules($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->get('employee_schedules')->result_array();
    }


    public function get_user_day_schedule($user_id, $day_of_week) {
        $this->db->where('user_id', $user_id);
        $this->db->where('day_of_week', $day_of_week);
        return $this->db->get('employee_schedules')->row_array();
    }


    public function update_user_schedule($user_id, $day_of_week, $is_working_day, $custom_holiday_reason = null) {
  
        $existing = $this->get_user_day_schedule($user_id, $day_of_week);

        $data = [
            'user_id' => $user_id,
            'day_of_week' => $day_of_week,
            'is_working_day' => $is_working_day,
            'custom_holiday_reason' => $custom_holiday_reason,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($existing) {
  
            $this->db->where('user_id', $user_id);
            $this->db->where('day_of_week', $day_of_week);
            return $this->db->update('employee_schedules', $data);
        } else {

            $data['created_at'] = date('Y-m-d H:i:s');
            return $this->db->insert('employee_schedules', $data);
        }
    }


    public function batch_update_schedules($schedules) {
        return $this->db->insert_batch('employee_schedules', $schedules);
    }


    public function is_user_working($user_id, $date) {

        $day_of_week = date('l', strtotime($date));

    
        $schedule = $this->get_user_day_schedule($user_id, $day_of_week);


        if (empty($schedule)) {
            return true;
        }

        return $schedule['is_working_day'] == 1;
    }
}