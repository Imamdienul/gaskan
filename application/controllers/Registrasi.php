<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Registrasi_m');
        $this->load->model('Wilayah');
        $this->load->helper('Whatsapp');
        $this->load->helper('Telegram');
    }

    function update_foto_identitas()
    {
        // file config
        $filename = $this->input->post('fnama_lengkap') . '_' . date('d/m/Y');
        $config['overwrite'] = false;
        $config['upload_path'] = './uploads/registrasi/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['file_name'] = $filename;
        $config['max_size'] = 2048;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('flampiran')) {
            $file = $this->upload->data("file_name");
            $post = $this->input->post(null, TRUE);
            $this->Registrasi_m->update_foto_identitas($post, $file);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Update foto identitas berhasil');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->set_flashdata('warning', 'Foto KTP / SIM / Passport harus terisi');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function index()
{
    // file config
    $filename = $this->input->post('fnama_lengkap') . '_' . date('d/m/Y');
    $config['overwrite'] = false;
    $config['upload_path'] = './uploads/registrasi/';
    $config['allowed_types'] = 'png|jpg|jpeg';
    $config['file_name'] = $filename;
    $config['max_size'] = 2048;

    $registrasi = $this->Registrasi_m;
    $validation = $this->form_validation;
    $validation->set_rules($registrasi->rules());

    $no_urut_registrasi = $this->Registrasi_m->get_no_urut_registrasi();
    $data['no_regis'] = date('dmy') . sprintf("%04d", $no_urut_registrasi);
    $data['provinsi'] = $this->Wilayah->get_all_provinsi();
    
    if ($validation->run() == FALSE) {
        // Jika validasi gagal, tampilkan pesan error dan alasan
        $errors = $validation->error_array();
        foreach ($errors as $error) {
            echo "Gagal: " . $error . "<br>";
        }
        $this->load->view('registrasi/index', $data);
    } else {
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('flampiran')) {
            $file = $this->upload->data("file_name");
            $post = $this->input->post(null, TRUE);
            $registrasi->add_customer($post, $file);
            $text_wa = 'Hallo ' . ucwords($post['fnama_lengkap']) .
                '
                
Terima kasih sudah melakukan registrasi
data anda sudah kami terima.

Nomor Registrasi Anda : ' . $data['no_regis'] . '

Admin kami akan segara menghubungi anda untuk melakukan konfirmasi jadwal pemasangan.

Salam,
Gisaka Media';
            if ($this->db->affected_rows() > 0) {
                telegram_notif_registrasi_pelanggan($post);
                $notif = send_wa($post['fnowa'], $text_wa);
                $wa_ade = '087776451664';
                send_wa($wa_ade, $text_wa);
                if ($notif == 200) {
                    $this->session->set_flashdata('success', 'Registrasi berhasil ' . $notif);
                    redirect('registrasi/success/' . encrypt_url($data['no_regis']), 'refresh');
                } else {
                    $this->session->set_flashdata('success', 'Registrasi berhasil ' . $notif);
                    redirect('registrasi/success/' . encrypt_url($data['no_regis']), 'refresh');
                }
            } else {
                echo "Gagal: Terjadi kesalahan saat menyimpan data registrasi.";
            }
        } else {
            $file = null;
            $error = $this->upload->display_errors();
            echo "Gagal: " . $error;
            $data['provinsi'] = $this->Wilayah->get_all_provinsi();
            $this->load->view('registrasi/index', $data);
        }
    }
}

    // AJAX methods to get region data
    public function get_kabupaten()
    {
        $provinsi_id = $this->input->post('provinsi_id', TRUE);
        $data = $this->Wilayah->get_kabupaten_by_provinsi($provinsi_id);
        echo json_encode($data);
    }
    
    public function get_kecamatan()
    {
        $kabupaten_id = $this->input->post('kabupaten_id', TRUE);
        $data = $this->Wilayah->get_kecamatan_by_kabupaten($kabupaten_id);
        echo json_encode($data);
    }
    
    public function get_desa()
    {
        $kecamatan_id = $this->input->post('kecamatan_id', TRUE);
        $data = $this->Wilayah->get_desa_by_kecamatan($kecamatan_id);
        echo json_encode($data);
    }

    function send_wa()
    {
        $no_wa = '087776451664';
        $pesan = 'ada yang registrasi nih';
        $image = 'NUGRAHA_AGUNG_PRATAMA_04042024.jpeg';
        $notif = send_wa_with_image($no_wa, $pesan, $image);
        echo $notif;
    }

    function success($noregis = null)
    {
        if (!$noregis) {
            redirect('registrasi', 'refresh');
        } else {
            $nomor_registrasi = decrypt_url($noregis);
            $data['data'] = $this->Registrasi_m->get_by_no_registrasi($nomor_registrasi);
            if ($data['data']) {
                $data['noregis'] = $nomor_registrasi;
                $this->load->view('registrasi/done', $data);
            } else {
                $this->session->set_flashdata('warning', 'Data tidak ditemukan!');
                // redirect('registrasi', 'refresh');
            }
        }
    }
    
    function edit($id_registrasi_customer)
    {
        $data['regis'] = $this->Registrasi_m->get_by_id_registrasi(decrypt_url($id_registrasi_customer));
        $data['provinsi'] = $this->Wilayah->get_all_provinsi();
        $this->load->view('registrasi/edit', $data);
    }
    
    function update()
    {
        $post = $this->input->post(null, TRUE);
        $this->Registrasi_m->update_registrasi($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Edit data registrasi berhasil!');
            redirect('customer/browse_registrasi', 'refresh');
        } else {
            $this->session->set_flashdata('warning', 'Edit data registrasi gagal!');
            redirect('customer/browse_registrasi', 'refresh');
        }
    }
    
    public function delete($id)
    {
        $this->Registrasi_m->delete(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data registrasi berhasil dihapus!');
            redirect('customer/browse_registrasi', 'refresh');
        }
    }
}

/* End of file Registrasi.php */