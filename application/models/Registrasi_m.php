<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi_m extends CI_Model
{
    private $_table = 'registrasi_customer';
    public $id_registrasi_customer;
    public $nomor_registrasi;
    public $no_urut_registrasi;
    public $jenis_formulir;
    public $nama_lengkap;
    public $jenkel;
    public $tgl_lahir;
    public $nomor_identitas;
    public $jenis_identitas;
    public $alamat_identitas;
    public $foto_identitas;
    public $kota;
    public $kode_pos;
    public $faksimili;
    public $whatsapp;
    public $seluler;
    public $email;
    public $jenis_layanan;
    public $bandwidth;
    public $bandwidth_lainnya;
    public $alamat_pemasangan;
    public $rt;
    public $rw;
    public $desa;
    public $kecamatan;
    public $kota_pemasangan;
    public $kode_pos_pemasangan;
    public $jangka_waktu_berlangganan;
    public $nomor_npwp;
    public $jangka_waktu_berlangganan_lainnya;
    public $tgl_pemasangan;
    
    public function rules()
    {
        return [
            [
                'field' => 'fnama_lengkap',
                'label' => 'nama lengkap',
                'rules' => 'required'
            ],
            [
                'field' => 'fjenkel',
                'label' => 'jenis kelamin',
                'rules' => 'required'
            ],
            [
                'field' => 'fjenis_formulir',
                'label' => 'jenis formulir',
                'rules' => 'required'
            ],
            [
                'field' => 'ftgl_lahir',
                'label' => 'tanggal lahir',
                'rules' => 'required'
            ],
            [
                'field' => 'fnomor_identitas',
                'label' => 'nomor identitas',
                'rules' => 'required|min_length[14]|max_length[16]|numeric'
            ],
            [
                'field' => 'fjenis_identitas',
                'label' => 'jenis identitas',
                'rules' => 'required'
            ],
            [
                'field' => 'fprovinsi_identitas',
                'label' => 'provinsi identitas',
                'rules' => 'required'
            ],
            [
                'field' => 'fkabupaten_identitas',
                'label' => 'kabupaten identitas',
                'rules' => 'required'
            ],
            [
                'field' => 'fkecamatan_identitas',
                'label' => 'kecamatan identitas',
                'rules' => 'required'
            ],
            [
                'field' => 'fdesa_identitas',
                'label' => 'desa identitas',
                'rules' => 'required'
            ],
            [
                'field' => 'fdetail_alamat_identitas',
                'label' => 'detail alamat identitas',
                'rules' => 'required'
            ],
            [
                'field' => 'fkode_pos',
                'label' => 'kode pos',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'fnowa',
                'label' => 'whatsapp',
                'rules' => 'required|numeric|min_length[13]|max_length[14]'
            ],
            [
                'field' => 'fseluler',
                'label' => 'seluller',
                'rules' => 'required|numeric|min_length[13]|max_length[14]'
            ],
            [
                'field' => 'femail',
                'label' => 'email',
                'rules' => 'required|valid_email'
            ],
            [
                'field' => 'fjenis_layanan',
                'label' => 'jenis layanan',
                'rules' => 'required'
            ],
            [
                'field' => 'fbandwidth',
                'label' => 'bandwidth',
                'rules' => 'required'
            ],
            [
                'field' => 'fprovinsi_pemasangan',
                'label' => 'provinsi pemasangan',
                'rules' => 'required'
            ],
            [
                'field' => 'fkabupaten_pemasangan',
                'label' => 'kabupaten pemasangan',
                'rules' => 'required'
            ],
            [
                'field' => 'fkecamatan_pemasangan',
                'label' => 'kecamatan pemasangan',
                'rules' => 'required'
            ],
            [
                'field' => 'fdesa_pemasangan',
                'label' => 'desa pemasangan',
                'rules' => 'required'
            ],
            [
                'field' => 'fdetail_alamat_pemasangan',
                'label' => 'detail alamat pemasangan',
                'rules' => 'required'
            ],
            [
                'field' => 'frt',
                'label' => 'RT',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'frw',
                'label' => 'RW',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'fkode_pos_pemasangan',
                'label' => 'kode pos pemasangan',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'fjangka_waktu_berlangganan',
                'label' => 'jangka waktu berlangganan',
                'rules' => 'required'
            ],
            [
                'field' => 'ftgl_pemasangan',
                'label' => 'tanggal pemasangan',
                'rules' => 'required'
            ],
            [
                'field' => 'fnpwp',
                'label' => 'nomor NPWP',
                'rules' => 'numeric|max_length[16]'
            ],
        ];
    }
    
    public function get_all_data_registrasi()
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->order_by('id_registrasi_customer', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_by_id_registrasi($id)
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('id_registrasi_customer', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function get_by_nomor_identitas($id)
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('nomor_identitas', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function add_customer($post, $file)
    {
        $post = $this->input->post();
        $this->load->model('Wilayah');
        
        // Get names from IDs for address formatting
        $provinsi_identitas = $this->Wilayah->get_nama_provinsi($post['fprovinsi_identitas']);
        $kabupaten_identitas = $this->Wilayah->get_nama_kabupaten($post['fkabupaten_identitas']);
        $kecamatan_identitas = $this->Wilayah->get_nama_kecamatan($post['fkecamatan_identitas']);
        $desa_identitas = $this->Wilayah->get_nama_desa($post['fdesa_identitas']);
        
        $provinsi_pemasangan = $this->Wilayah->get_nama_provinsi($post['fprovinsi_pemasangan']);
        $kabupaten_pemasangan = $this->Wilayah->get_nama_kabupaten($post['fkabupaten_pemasangan']);
        $kecamatan_pemasangan = $this->Wilayah->get_nama_kecamatan($post['fkecamatan_pemasangan']);
        $desa_pemasangan = $this->Wilayah->get_nama_desa($post['fdesa_pemasangan']);
        
        // Format addresses
        $alamat_identitas_lengkap = $post['fdetail_alamat_identitas'] . ', ' . 
                                    'Desa ' . $desa_identitas . ', ' . 
                                    'Kecamatan ' . $kecamatan_identitas . ', ' . 
                                    'Kabupaten ' . $kabupaten_identitas . ', ' . 
                                    'Provinsi ' . $provinsi_identitas;
                                    
        $alamat_pemasangan_lengkap = $post['fdetail_alamat_pemasangan'] . ', ' . 
                                     'RT ' . $post['frt'] . ', ' .
                                     'RW ' . $post['frw'] . ', ' .
                                     'Desa ' . $desa_pemasangan . ', ' . 
                                     'Kecamatan ' . $kecamatan_pemasangan . ', ' . 
                                     'Kabupaten ' . $kabupaten_pemasangan . ', ' . 
                                     'Provinsi ' . $provinsi_pemasangan;
        
        $this->nomor_registrasi = date('dmy') . sprintf("%04d", $this->get_no_urut_registrasi());
        $this->no_urut_registrasi = $this->get_no_urut_registrasi();
        $this->jenis_formulir = $post['fjenis_formulir'];
        $this->nama_lengkap = $post['fnama_lengkap'];
        $this->jenkel = $post['fjenkel'];
        $this->nomor_npwp = $post['fnpwp'];
        $this->tgl_lahir = $post['ftgl_lahir'];
        $this->nomor_identitas = $post['fnomor_identitas'];
        $this->jenis_identitas = $post['fjenis_identitas'];
        $this->alamat_identitas = $alamat_identitas_lengkap;
        $this->foto_identitas = $file;
        $this->kota = $kabupaten_identitas; // Use kabupaten name for kota
        $this->kode_pos = $post['fkode_pos'];
        $this->faksimili = $post['ffaksimili'];
        $this->whatsapp = $post['fnowa'];
        $this->seluler = $post['fseluler'];
        $this->email = $post['femail'];
        $this->jenis_layanan = $post['fjenis_layanan'];
        $this->bandwidth = $post['fbandwidth'];
        
        if ($post['fbandwidth'] == "Lainnya") {
            $blainnya = $post['fbandwidth_lainnya'];
        } else {
            $blainnya = null;
        }
        
        $this->bandwidth_lainnya = $blainnya;
        $this->alamat_pemasangan = $alamat_pemasangan_lengkap;
        $this->rt = $post['frt'];
        $this->rw = $post['frw'];
        $this->desa = $desa_pemasangan;
        $this->kecamatan = $kecamatan_pemasangan;
        $this->kota_pemasangan = $kabupaten_pemasangan;
        $this->kode_pos_pemasangan = $post['fkode_pos_pemasangan'];
        $this->jangka_waktu_berlangganan = $post['fjangka_waktu_berlangganan'];
        
        if ($post['fjangka_waktu_berlangganan'] == "Lainnya") {
            $jlainnya = $post['fjangka_waktu_berlangganan_lainnya'];
        } else {
            $jlainnya = null;
        }
        
        $this->jangka_waktu_berlangganan_lainnya = $jlainnya;
        $this->tgl_pemasangan = $post['ftgl_pemasangan'];
        $this->db->insert($this->_table, $this);
    }

    function get_no_urut_registrasi()
    {
        $this->db->select('no_urut_registrasi');
        $this->db->from($this->_table);
        $this->db->order_by('id_registrasi_customer', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if (date('m') == 1 && date('d') == 1) {
            return 1;
        } else {
            return $query->row()->no_urut_registrasi + 1;
        }
    }
    
    function get_by_no_registrasi($noregis = null)
    {
        $this->db->select('nomor_registrasi');
        $this->db->from($this->_table);
        $this->db->where('nomor_registrasi', $noregis);
        $query = $this->db->get();
        if ($query === null) {
            return null;
        } else {
            return $query->row();
        }
    }
    
    function update_foto_identitas($post, $file)
    {
        $this->db->set('foto_identitas', $file);
        $this->db->where('id_registrasi_customer', decrypt_url($post['fid_regis']));
        $this->db->update($this->_table);
    }
    
    function update_registrasi($post)
    {
        $this->load->model('Wilayah');
        
        // Get names from IDs for address formatting
        $provinsi_identitas = $this->Wilayah->get_nama_provinsi($post['fprovinsi_identitas']);
        $kabupaten_identitas = $this->Wilayah->get_nama_kabupaten($post['fkabupaten_identitas']);
        $kecamatan_identitas = $this->Wilayah->get_nama_kecamatan($post['fkecamatan_identitas']);
        $desa_identitas = $this->Wilayah->get_nama_desa($post['fdesa_identitas']);
        
        $provinsi_pemasangan = $this->Wilayah->get_nama_provinsi($post['fprovinsi_pemasangan']);
        $kabupaten_pemasangan = $this->Wilayah->get_nama_kabupaten($post['fkabupaten_pemasangan']);
        $kecamatan_pemasangan = $this->Wilayah->get_nama_kecamatan($post['fkecamatan_pemasangan']);
        $desa_pemasangan = $this->Wilayah->get_nama_desa($post['fdesa_pemasangan']);
        
        // Format addresses
        $alamat_identitas_lengkap = $post['fdetail_alamat_identitas'] . ', ' . 
                                    'Desa ' . $desa_identitas . ', ' . 
                                    'Kecamatan ' . $kecamatan_identitas . ', ' . 
                                    'Kabupaten ' . $kabupaten_identitas . ', ' . 
                                    'Provinsi ' . $provinsi_identitas;
                                    
        $alamat_pemasangan_lengkap = $post['fdetail_alamat_pemasangan'] . ', ' . 
                                     'RT ' . $post['frt'] . ', ' .
                                     'RW ' . $post['frw'] . ', ' .
                                     'Desa ' . $desa_pemasangan . ', ' . 
                                     'Kecamatan ' . $kecamatan_pemasangan . ', ' . 
                                     'Kabupaten ' . $kabupaten_pemasangan . ', ' . 
                                     'Provinsi ' . $provinsi_pemasangan;
                                     
        $this->db->set('jenis_formulir', $post['fjenis_formulir']);
        $this->db->set('nama_lengkap', $post['fnama_lengkap']);
        $this->db->set('jenkel', $post['fjenkel']);
        $this->db->set('nomor_npwp', $post['fnpwp']);
        $this->db->set('tgl_lahir', $post['ftgl_lahir']);
        $this->db->set('nomor_identitas', $post['fnomor_identitas']);
        $this->db->set('jenis_identitas', $post['fjenis_identitas']);
        $this->db->set('alamat_identitas', $alamat_identitas_lengkap);
        $this->db->set('kota', $kabupaten_identitas);
        $this->db->set('kode_pos', $post['fkode_pos']);
        $this->db->set('faksimili', $post['ffaksimili']);
        $this->db->set('whatsapp', $post['fnowa']);
        $this->db->set('seluler', $post['fseluler']);
        $this->db->set('email', $post['femail']);
        $this->db->set('jenis_layanan', $post['fjenis_layanan']);
        $this->db->set('bandwidth', $post['fbandwidth']);
        
        if ($post['fbandwidth'] == "Lainnya") {
            $blainnya = $post['fbandwidth_lainnya'];
        } else {
            $blainnya = null;
        }
        
        $this->db->set('bandwidth_lainnya', $blainnya);
        $this->db->set('alamat_pemasangan', $alamat_pemasangan_lengkap);
        $this->db->set('rt', $post['frt']);
        $this->db->set('rw', $post['frw']);
        $this->db->set('desa', $desa_pemasangan);
        $this->db->set('kecamatan', $kecamatan_pemasangan);
        $this->db->set('kota_pemasangan', $kabupaten_pemasangan);
        $this->db->set('kode_pos_pemasangan', $post['fkode_pos_pemasangan']);
        $this->db->set('jangka_waktu_berlangganan', $post['fjangka_waktu_berlangganan']);
        
        if ($post['fjangka_waktu_berlangganan'] == "Lainnya") {
            $jlainnya = $post['fjangka_waktu_berlangganan_lainnya'];
        } else {
            $jlainnya = null;
        }
        
        $this->db->set('jangka_waktu_berlangganan_lainnya', $jlainnya);
        $this->db->set('tgl_pemasangan', $post['ftgl_pemasangan']);
        $this->db->where('id_registrasi_customer', decrypt_url($post['fid_regis']));
        $this->db->update($this->_table);
    }
    
    public function delete($id)
    {
        $this->db->where('id_registrasi_customer', $id);
        $this->db->delete($this->_table);
    }
}

/* End of file Registrasi_m.php */