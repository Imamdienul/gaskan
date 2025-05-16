<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_pdf extends CI_Controller {
    public function index() {
        // Contoh data dummy (kamu bisa ambil dari database juga)
        $activation_data = (object)[
            'id_odp' => 1,
            'tgl_pasang' => '2025-05-02',
            'waktu_pasang' => '14:00:00',
            'nama_paket' => 'Paket 10 Mbps',
            'panjang_kabel' => '25',
            'nomor_roll_kabel' => 'KBL123',
            'nama_wilayah' => 'Jakarta Timur',
            'merk_modem' => 'ZTE',
            'tipe_modem' => 'F660',
            'sn_modem' => 'SN12345678',
            'mac_address' => 'AA:BB:CC:DD:EE:FF',
            'port_odp' => '3',
            'redaman_pelanggan' => '-19',
            'foto_koneksi_odp' => 'foto1.jpg',
            'foto_redaman_pelanggan' => 'foto2.jpg',
            'foto_instalasi' => 'foto3.jpg',
            'foto_rumah' => 'foto4.jpg',
            'catatan' => 'Pasang lancar tanpa kendala',
            'nama_teknisi' => 'Fajar',
            'phone_user' => '08123456789',
            'email_user' => 'fajar@example.com',
        ];

        $customer_data = (object)[
            'nama_lengkap' => 'Andi Setiawan',
            'whatsapp' => '6281234567890',
            'alamat_pemasangan' => 'Jl. Melati No.10, Jakarta Timur',
        ];

        // Panggil fungsi PDF
        $this->load->helper('email_helper'); // Pastikan fungsi `generate_activation_pdf` ada di helper ini
        $pdf_content = generate_activation_pdf($activation_data, $customer_data);

        // Set header untuk menampilkan PDF di browser
        $this->load->helper('download');
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="activation_request.pdf"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        
        // Outputkan PDF
        echo $pdf_content;
    }
}
