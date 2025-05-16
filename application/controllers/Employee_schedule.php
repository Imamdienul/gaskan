<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_schedule extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['employee_schedule_model', 'attendance_model']);
        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');
    }


    public function index() {
      
        $data['users'] = $this->attendance_model->get_all_users();
        

        $data['days'] = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        
        $data['schedules'] = [];
        foreach ($data['users'] as $user) {
            $user_schedules = $this->employee_schedule_model->get_user_schedules($user['id_user']);
            $data['schedules'][$user['id_user']] = array_column($user_schedules, null, 'day_of_week');
        }

        $data['title'] = 'Pengaturan Jadwal Karyawan';
        $this->template->load('shared/index', 'employee_schedule/index', $data);
    }

  
    public function update_schedule() {
        $this->form_validation->set_rules('user_id', 'User', 'required|integer');
        $this->form_validation->set_rules('day_of_week', 'Day', 'required');
        $this->form_validation->set_rules('is_working_day', 'Working Day', 'required|in_list[0,1]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_schedule');
        }

        $user_id = $this->input->post('user_id');
        $day_of_week = $this->input->post('day_of_week');
        $is_working_day = $this->input->post('is_working_day');
        $custom_holiday_reason = $this->input->post('custom_holiday_reason');

        $result = $this->employee_schedule_model->update_user_schedule(
            $user_id, 
            $day_of_week, 
            $is_working_day, 
            $custom_holiday_reason
        );

        if ($result) {
            $this->session->set_flashdata('success', 'Jadwal berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui jadwal');
        }

        redirect('employee_schedule');
    }
}