<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Calculator extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('calculator_model');
    }
    
    public function index() {
        $data = array(
            'title' => 'Kalkulator Fiber Optik',
            'description' => 'Perhitungan daya dan redaman dalam jaringan fiber optik'
        );

        $this->template->load('shared/index', 'calculator/index', $data);
    }
    
    public function calculate() {
        $input = $this->input->post();

        $distance = floatval($input['distance']);
        $tx_power = floatval($input['tx_power']);
        $rx_sensitivity = floatval($input['rx_sensitivity']);
        $splitter_types = $input['splitter_type'];

        $fiber_loss_coef = 0.35; 
        $fiber_loss = $distance * $fiber_loss_coef;

        $splitter_loss_total = 0;
        $splitter_details = [];
        
        // Calculate power after fiber loss
        $power_after_fiber = $tx_power - $fiber_loss;
        
        foreach ($splitter_types as $splitter) {
            $loss = $this->calculator_model->get_splitter_loss($splitter);
            $splitter_loss_total += $loss;
            
            // Get splitter outputs for visualization
            $splitter_details[] = [
                'type' => $splitter,
                'input_power' => number_format($power_after_fiber, 2) . ' dBm',
                'outputs' => $this->calculator_model->get_splitter_outputs($splitter, $power_after_fiber),
                'loss' => number_format($loss, 2) . ' dB'
            ];
            
            // Update power for next splitter (simplified)
            $power_after_fiber -= $loss;
        }

        $total_loss = $fiber_loss + $splitter_loss_total;
        $rx_power = $tx_power - $total_loss;
        $power_margin = $rx_power - $rx_sensitivity;

        $result = array(
            'fiber_loss' => number_format($fiber_loss, 2),
            'splitter_loss' => number_format($splitter_loss_total, 2),
            'total_loss' => number_format($total_loss, 2),
            'rx_power' => number_format($rx_power, 2),
            'power_margin' => number_format($power_margin, 2),
            'status' => ($power_margin > 0) ? 'Baik' : 'Tidak Baik',
            'warnings' => $this->check_warnings($power_margin, $distance),
            'splitter_details' => $splitter_details,
            'power_after_fiber' => number_format($tx_power - $fiber_loss, 2)
        );

        echo json_encode($result);
    }

    private function check_warnings($power_margin, $distance) {
        $warnings = array();

        if ($power_margin < 0) {
            $warnings[] = 'PERINGATAN: Margin daya negatif. Sistem tidak akan bekerja dengan baik!';
        } elseif ($power_margin < 3) {
            $warnings[] = 'PERINGATAN: Margin daya rendah (<3dB). Disarankan untuk mengurangi redaman atau meningkatkan daya pancar.';
        }

        if ($distance > 20) {
            $warnings[] = 'PERINGATAN: Jarak lebih dari 20km. Pertimbangkan penggunaan penguat optik.';
        }

        return $warnings;
    }
}