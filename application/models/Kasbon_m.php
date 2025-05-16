<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasbon_m extends CI_Model
{
    private $_table = "kasbon";
    public $no_dokumen;
    public $id_user;
    public $keperluan;
    public $project_id;
    public $nominal;
    public $cara_bayar;
    public $no_urut_kasbon;
    public $lampiran;
    public $status_terakhir;
    public $note;
    public $deleted;
    public function rules()
    {
        return [
            [
                'field' => 'fkeperluan',
                'label' => 'keperluan',
                'rules' => 'required'
            ],
            [
                'field' => 'fnominal',
                'label' => 'nominal',
                'rules' => 'required|min_length[3]'
            ],
            [
                'field' => 'fcara_pencairan',
                'label' => 'cara pencairan',
                'rules' => 'required'
            ],
            [
                'field' => 'fnama_project',
                'label' => 'project',
                'rules' => 'required'
            ],
            [
                'field' => 'fid_project',
                'label' => 'project',
                'rules' => 'required'
            ],
        ];
    }
    

    public function add_kasbon($post, $file)
    {
        $post = $this->input->post();
        $this->id_user = $this->session->userdata('id_user');
        $this->no_dokumen = $post['fno_dokumen'];
        $this->project_id = $post['fid_project'];
        $this->status_terakhir = 'created';
        $this->lampiran = $file;
        $this->keperluan = $post['fkeperluan'];
        $this->nominal = str_replace(".", "", $post['fnominal']);
        $this->cara_bayar = $post['fcara_pencairan'];
        $this->note = $post['fnote'];
        $this->no_urut_kasbon = $this->get_no_urut_kasbon();
        $this->deleted = 0;
        $this->db->insert($this->_table, $this);
    }
    function get_total_pengajuan_keuangan($bln, $thn)
    {
        $this->db->select_sum('nominal');
        $this->db->join('users', 'users.id_user = kasbon.id_user', 'left');
        if ($this->session->userdata('group') != 1 && $this->session->userdata('group') != 12) {
            $this->db->where('kasbon.id_user', $this->session->userdata('id_user'));
        }
        $this->db->where('kasbon.deleted', 0);
        $this->db->where('month(kasbon.created_date)', $bln);
        $this->db->where('year(kasbon.created_date)', $thn);
        $this->db->order_by('id_kasbon', 'desc');
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row()->nominal;
    }
    function get_total_pengajuan_keuangan_filter($karyawan, $tgl_awal, $tgl_akhir, $kategori)
    {
        $this->db->select_sum('nominal');
        $this->db->join('users', 'users.id_user = kasbon.id_user', 'left');
        if ($this->session->userdata('group') != 1 && $this->session->userdata('group') != 12) {
            $this->db->where('kasbon.id_user', $this->session->userdata('id_user'));
        }
        $this->db->where('kasbon.deleted', 0);
        if ($karyawan != 'all') {
            $this->db->where('kasbon.id_user', $karyawan);
        }
        if ($tgl_awal != null) {
            $this->db->where('kasbon.created_date >=', $tgl_awal);
        }
        if ($tgl_akhir != null) {
            $this->db->where('kasbon.created_date <=', $tgl_akhir);
        }
        if ($kategori != 'all') {
            $this->db->where('kasbon.keperluan', $kategori);
        }

        $this->db->order_by('id_kasbon', 'desc');
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row()->nominal;
    }
    function get_total_by_status($bln, $thn, $status)
    {
        $this->db->select_sum('nominal');
        $this->db->join('status_kasbon', 'status_kasbon.no_dokumen = kasbon.no_dokumen', 'left');
        $this->db->join('users', 'users.id_user = kasbon.id_user', 'left');
        if ($this->session->userdata('group') != 1 && $this->session->userdata('group') != 12) {
            $this->db->where('kasbon.id_user', $this->session->userdata('id_user'));
        }
        $this->db->where('status_kasbon.status_kasbon', $status);
        $this->db->where('kasbon.deleted', 0);
        $this->db->where('month(kasbon.created_date)', $bln);
        $this->db->where('year(kasbon.created_date)', $thn);
        $this->db->order_by('id_kasbon', 'desc');
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row()->nominal;
    }
    function get_total_by_status_filter($karyawan, $tgl_awal, $tgl_akhir, $kategori, $status)
    {
        $this->db->select_sum('nominal');
        $this->db->join('status_kasbon', 'status_kasbon.no_dokumen = kasbon.no_dokumen', 'left');
        $this->db->join('users', 'users.id_user = kasbon.id_user', 'left');
        if ($this->session->userdata('group') != 1 && $this->session->userdata('group') != 12) {
            $this->db->where('kasbon.id_user', $this->session->userdata('id_user'));
        }
        $this->db->where('status_kasbon.status_kasbon', $status);
        if ($karyawan != 'all') {
            $this->db->where('kasbon.id_user', $karyawan);
        }
        if ($tgl_awal != null) {
            $this->db->where('kasbon.created_date >=', $tgl_awal);
        }
        if ($tgl_akhir != null) {
            $this->db->where('kasbon.created_date <=', $tgl_akhir);
        }
        if ($kategori != 'all') {
            $this->db->where('kasbon.keperluan', $kategori);
        }

        $this->db->where('kasbon.deleted', 0);
        $this->db->order_by('id_kasbon', 'desc');
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row()->nominal;
    }
   
    public function get_all_kasbon_for_export($post)
    {
        $this->db->select('kasbon.*, users.nama_user, users.nik, kategori_keuangan.kategori_keuangan');
        $this->db->from($this->_table);
        $this->db->join('kategori_keuangan', 'kategori_keuangan.id_kategori_keuangan = kasbon.keperluan', 'left');
        $this->db->join('users', 'users.id_user = kasbon.id_user', 'left');

        $this->db->where('kasbon.deleted', 0);
        if ($post['fkaryawan'] != 'all') {
            $this->db->where('kasbon.id_user', $post['fkaryawan']);
        }
        if ($post['fproject'] != 'all') {
            $this->db->where('kasbon.project_id', $post['fproject']);
        }
        if ($post['ftgl_awal'] != null) {
            $this->db->where('kasbon.created_date >=', $post['ftgl_awal']);
        }
        if ($post['ftgl_akhir'] != null) {
            $this->db->where('kasbon.created_date <=', $post['ftgl_akhir']);
        }
        if ($post['fkategori']) {
            if (stripos(json_encode($post['fkategori']), 'all') == false) {
                $this->db->where_in('kasbon.keperluan', $post['fkategori']);
            }
        }
        if ($post['fstatus']) {
            if (stripos(json_encode($post['fstatus']), 'all') == false) {
                $this->db->where_in('kasbon.status_terakhir', $post['fstatus']);
            }
        }


        $this->db->order_by('id_kasbon', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_total_kasbon_for_export($post)
    {
        $this->db->select_sum('nominal');
        $this->db->from($this->_table);
        $this->db->join('kategori_keuangan', 'kategori_keuangan.id_kategori_keuangan = kasbon.keperluan', 'left');
        $this->db->join('users', 'users.id_user = kasbon.id_user', 'left');

        $this->db->where('kasbon.deleted', 0);
        if ($post['fkaryawan'] != 'all') {
            $this->db->where('kasbon.id_user', $post['fkaryawan']);
        }
        if ($post['fproject'] != 'all') {
            $this->db->where('kasbon.project_id', $post['fproject']);
        }
        if ($post['ftgl_awal'] != null) {
            $this->db->where('kasbon.created_date >=', $post['ftgl_awal']);
        }
        if ($post['ftgl_akhir'] != null) {
            $this->db->where('kasbon.created_date <=', $post['ftgl_akhir']);
        }
        if ($post['fkategori']) {
            if (stripos(json_encode($post['fkategori']), 'all') == false) {
                $this->db->where_in('kasbon.keperluan', $post['fkategori']);
            }
        }
        if ($post['fstatus']) {
            if (stripos(json_encode($post['fstatus']), 'all') == false) {
                $this->db->where_in('kasbon.status_terakhir', $post['fstatus']);
            }
        }
        $this->db->order_by('id_kasbon', 'desc');
        $query = $this->db->get();
        return $query->row()->nominal;
    }
    public function get_all_kasbon_by_filter($karyawan, $tgl_awal, $tgl_akhir, $kategori)
    {
        $this->db->select('kasbon.*, users.nama_user, users.nik, kategori_keuangan.kategori_keuangan');
        $this->db->from($this->_table);
        $this->db->join('kategori_keuangan', 'kategori_keuangan.id_kategori_keuangan = kasbon.keperluan', 'left');
        $this->db->join('users', 'users.id_user = kasbon.id_user', 'left');

        $this->db->where('kasbon.deleted', 0);
        if ($karyawan != 'all') {
            $this->db->where('kasbon.id_user', $karyawan);
        }
        if ($tgl_awal != null) {
            $this->db->where('kasbon.created_date >=', $tgl_awal);
        }
        if ($tgl_akhir != null) {
            $this->db->where('kasbon.created_date <=', $tgl_akhir);
        }
        if ($kategori != 'all') {
            $this->db->where('kasbon.keperluan', $kategori);
        }

        $this->db->order_by('id_kasbon', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_by_id_kasbon($id)
    {
        $this->db->select('kasbon.*, users.nama_user, users.nik, kategori_keuangan.kategori_keuangan, project.nama_project');
        $this->db->from($this->_table);
        $this->db->join('users', 'users.id_user = kasbon.id_user', 'left');
        $this->db->join('kategori_keuangan', 'kategori_keuangan.id_kategori_keuangan = kasbon.keperluan', 'left');
        $this->db->join('project', 'project.project_id = kasbon.project_id', 'left');
        $this->db->where('kasbon.deleted', 0);
        $this->db->where('kasbon.id_kasbon', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function get_by_no_dokumen($no_dokumen)
    {
        $this->db->select('kasbon.*, users.nama_user, users.nik, kategori_keuangan.kategori_keuangan');
        $this->db->from($this->_table);
        $this->db->join('users', 'users.id_user = kasbon.id_user', 'left');
        $this->db->join('kategori_keuangan', 'kategori_keuangan.id_kategori_keuangan = kasbon.keperluan', 'left');
        $this->db->where('kasbon.deleted', 0);
        $this->db->where('kasbon.no_dokumen', $no_dokumen);
        $query = $this->db->get();
        return $query->row();
    }
    public function get_chat_id_by_id_kasbon($id_kasbon)
    {
        $this->db->select('kasbon.*, users.chat_id');
        $this->db->from($this->_table);
        $this->db->join('users', 'users.id_user = kasbon.id_user', 'left');
        $this->db->where('kasbon.deleted', 0);
        $this->db->where('kasbon.id_kasbon', $id_kasbon);
        $query = $this->db->get();
        return $query->row()->chat_id;
    }
    function get_no_urut_kasbon()
    {
        $this->db->select('no_urut_kasbon');
        $this->db->from($this->_table);
        $this->db->order_by('id_kasbon', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if (date('m') == 1 && date('d') == 1) {
            return 1;
        } else {
            return $query->row()->no_urut_kasbon + 1;
        }
    }
    public function get_kasbon_by_id($id_kasbon) {
        $this->db->select('kasbon.*, kategori_keuangan.kategori_keuangan');
        $this->db->from('kasbon');
        $this->db->join('kategori_keuangan', 'kasbon.keperluan = kategori_keuangan.id_kategori_keuangan', 'left');
        $this->db->where('kasbon.id_kasbon', $id_kasbon);
        return $this->db->get()->row();
    }
    
    public function update_kasbon($id_kasbon, $data) {
        $this->db->where('id_kasbon', $id_kasbon);
        return $this->db->update('kasbon', $data);
    }
    
    public function get_categories() {
        $this->db->where('deleted', 0);
        return $this->db->get('kategori_keuangan')->result();
    }
    public function get_all_kasbon($bln, $thn)
    {
        $this->db->select('kasbon.*, users.nama_user, users.nik, kategori_keuangan.kategori_keuangan');
        $this->db->from($this->_table);
        $this->db->join('kategori_keuangan', 'kategori_keuangan.id_kategori_keuangan = kasbon.keperluan', 'left');
        $this->db->join('users', 'users.id_user = kasbon.id_user', 'left');
        if ($this->session->userdata('group') != 1) {
            $this->db->where('kasbon.id_user', $this->session->userdata('id_user'));
        }
        $this->db->where('kasbon.deleted', 0);
        $this->db->where('month(kasbon.created_date)', $bln);
        $this->db->where('year(kasbon.created_date)', $thn);
        $this->db->order_by('id_kasbon', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    
    


    public function get_total_kasbon_gaji_by_bulan_by_user($bulan, $tahun, $id_user)
    {
        $this->db->select_sum('nominal');
        $this->db->join('status_kasbon', 'status_kasbon.no_dokumen = kasbon.no_dokumen');
        $this->db->where('kasbon.deleted', 0);
        $this->db->where('kasbon.keperluan', 1);
        $this->db->where('kasbon.id_user', $id_user);
        $this->db->where('status_kasbon.status_kasbon', 'closed');
        $this->db->where('month(kasbon.created_date)', $bulan);
        $this->db->where('year(kasbon.created_date)', $tahun);
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->row()->nominal;
    }
    public function get_kasbon_gaji_by_bulan_by_user($bulan, $tahun, $id_user)
    {
        $this->db->select('*');
        $this->db->join('status_kasbon', 'status_kasbon.no_dokumen = kasbon.no_dokumen');
        $this->db->join('kategori_keuangan', 'kategori_keuangan.id_kategori_keuangan = kasbon.keperluan');
        $this->db->where('kasbon.deleted', 0);
        $this->db->where('kasbon.keperluan', 1);
        $this->db->where('kasbon.id_user', $id_user);
        $this->db->where('status_kasbon.status_kasbon', 'closed');
        $this->db->where('month(kasbon.created_date)', $bulan);
        $this->db->where('year(kasbon.created_date)', $tahun);
        $this->db->from($this->_table);
        $query = $this->db->get();
        return $query->result();
    }
    public function update_status_terakhir($no_dokumen, $status)
    {
        $this->db->set('status_terakhir', $status);
        $this->db->where('no_dokumen', $no_dokumen);
        $this->db->update($this->_table);
    }
    public function delete_by_id($id_kasbon) {
    $this->db->select('no_dokumen');
    $this->db->where('id_kasbon', $id_kasbon);
    $query = $this->db->get('kasbon');

    if ($query->num_rows() > 0) {
        $no_dokumen = $query->row()->no_dokumen;

        $this->db->trans_start();

        $this->db->where('no_dokumen', $no_dokumen);
        $this->db->delete('status_kasbon');

        $this->db->where('id_kasbon', $id_kasbon);
        $this->db->delete('kasbon');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    return false;
}

}

/* End of file Kasbon_m.php */