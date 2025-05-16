<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fingerprint extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function register()
    {
        $fingerprint_id = $this->input->post('fingerprint_id');
        $id_user = $this->input->post('id_user'); // ID user bisa kosong, akan diisi nanti

        if (empty($fingerprint_id)) {
            $response = ['status' => false, 'message' => 'ID sidik jari tidak boleh kosong'];
            echo json_encode($response);
            return;
        }

        $data = [
            'fingerprint_id' => $fingerprint_id,
            'id_user' => $id_user // Bisa null jika belum diisi
        ];

        // Simpan ke database
        if ($this->db->insert('fingerprint_data', $data)) {
            $response = ['status' => true, 'message' => 'Data sidik jari berhasil disimpan'];
        } else {
            $response = ['status' => false, 'message' => 'Gagal menyimpan data sidik jari'];
        }

        echo json_encode($response);
    }
}
?>
