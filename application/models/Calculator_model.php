<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Calculator_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_splitter_loss($splitter_type) {
        $splitter_loss = array(
            '1:2' => 3.5,
            '1:4' => 7.0,
            '1:8' => 10.5,
            '1:16' => 14.0,
            '1:32' => 17.5,
            '1:64' => 21.0,
            '1:128' => 24.5,
            '2:2' => 4.0,
            '2:4' => 7.5,
            '2:8' => 11.0,
            '2:16' => 14.5,
            '2:32' => 18.0,
            '2:64' => 21.5,
            '95:5' => 0.3,
            '90:10' => 0.5,
            '85:15' => 0.7,
            '80:20' => 1.0,
            '75:25' => 1.2,
            '70:30' => 1.5,
            '65:35' => 1.9,
            '60:40' => 2.2,
            '55:45' => 2.6,
            '50:50' => 3.0
        );

        return isset($splitter_loss[$splitter_type]) ? $splitter_loss[$splitter_type] : 0;
    }

    public function get_splitter_types() {
        return array(
            '1:2' => 'Splitter 1:2 (3.5 dB)',
            '1:4' => 'Splitter 1:4 (7.0 dB)',
            '1:8' => 'Splitter 1:8 (10.5 dB)',
            '1:16' => 'Splitter 1:16 (14.0 dB)',
            '1:32' => 'Splitter 1:32 (17.5 dB)',
            '1:64' => 'Splitter 1:64 (21.0 dB)',
            '1:128' => 'Splitter 1:128 (24.5 dB)',
            '2:2' => 'Splitter 2:2 (4.0 dB)',
            '2:4' => 'Splitter 2:4 (7.5 dB)',
            '2:8' => 'Splitter 2:8 (11.0 dB)',
            '2:16' => 'Splitter 2:16 (14.5 dB)',
            '2:32' => 'Splitter 2:32 (18.0 dB)',
            '2:64' => 'Splitter 2:64 (21.5 dB)',
            '95:5' => 'Coupler 95:5 (0.3 dB)',
            '90:10' => 'Coupler 90:10 (0.5 dB)',
            '85:15' => 'Coupler 85:15 (0.7 dB)',
            '80:20' => 'Coupler 80:20 (1.0 dB)',
            '75:25' => 'Coupler 75:25 (1.2 dB)',
            '70:30' => 'Coupler 70:30 (1.5 dB)',
            '65:35' => 'Coupler 65:35 (1.9 dB)',
            '60:40' => 'Coupler 60:40 (2.2 dB)',
            '55:45' => 'Coupler 55:45 (2.6 dB)',
            '50:50' => 'Coupler 50:50 (3.0 dB)'
        );
    }
    
    public function get_splitter_outputs($splitter_type, $input_power) {
        $outputs = [];
        $loss = $this->get_splitter_loss($splitter_type);
        
        if (strpos($splitter_type, ':') !== false) {
            $parts = explode(':', $splitter_type);
            $input_count = $parts[0];
            $output_count = $parts[1];
            
            if ($input_count == 1) {
                // Standard splitter
                $output_power = $input_power - $loss;
                for ($i = 0; $i < $output_count; $i++) {
                    $outputs[] = number_format($output_power, 2) . ' dBm';
                }
            } elseif ($input_count == 2) {
                // 2-input splitter
                $output_power = $input_power - $loss;
                for ($i = 0; $i < $output_count; $i++) {
                    $outputs[] = number_format($output_power, 2) . ' dBm';
                }
            } else {
                // Coupler (uneven split)
                $main_output_power = $input_power - ($loss * 0.1); // Main output has less loss
                $tap_output_power = $input_power - $loss;
                
                $outputs[] = number_format($main_output_power, 2) . ' dBm (Main)';
                $outputs[] = number_format($tap_output_power, 2) . ' dBm (Tap)';
            }
        }
        
        return $outputs;
    }
}