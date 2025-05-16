<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Picqer\Barcode\BarcodeGeneratorPNG;

class Setting extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('WaktuOperasional_Model');
        date_default_timezone_set("asia/jakarta");
    }

    public function index()
    {
        $data['set'] = "setting";
        $data['waktuoperasional'] = $this->WaktuOperasional_Model->waktuoperasional();
        
        // Define the days array
        $data['days'] = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        // Initialize waktuOperasionalHari array
        $data['waktuOperasionalHari'] = [];
        foreach ($data['days'] as $englishDay => $hari) {
            $data['waktuOperasionalHari'][$englishDay] = ['masuk' => '', 'keluar' => ''];
            if (isset($data['waktuoperasional'])) {
                foreach ($data['waktuoperasional'] as $value) {
                    if ($value->day == $englishDay) {
                        if ($value->keterangan == 'masuk') {
                            $data['waktuOperasionalHari'][$englishDay]['masuk'] = $value->waktu_operasional;
                        } else if ($value->keterangan == 'keluar') {
                            $data['waktuOperasionalHari'][$englishDay]['keluar'] = $value->waktu_operasional;
                        }
                    }
                }
            }
        }
    
        $this->template->load('shared/index', 'setting/index', $data);
    }

    public function updateWaktuOperasional() {
        $masuk = $this->input->post('masuk');
        $keluar = $this->input->post('keluar'); 
        foreach ($masuk as $day => $waktu_masuk) {
            $waktu_keluar = isset($keluar[$day]) ? $keluar[$day] : ''; 
            $this->WaktuOperasional_Model->update_waktu_operasional($day, $waktu_masuk, $waktu_keluar);
        }
        $this->session->set_flashdata('pesan', 'Waktu operasional berhasil diperbarui!');
        redirect('setting');
    }
}
