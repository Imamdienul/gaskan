<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Survey_m extends CI_Model
{
    // Get customers who haven't been surveyed
    public function get_unsurveyed_customers()
    {
        $this->db->select('r.*, w.nama_wilayah, w.kecamatan, w.kabupaten');
        $this->db->from('registrasi_customer r');
        $this->db->join('wilayah w', 'r.kecamatan = w.kecamatan', 'left');
        
        $this->db->order_by('no_urut_registrasi', 'desc');
        return $this->db->get()->result();
    }
    
    // Get technicians (users with technician role)
    public function get_all_teknisi()
    {
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->join('group_users g', 'u.id_group_user = g.id_group_user');
        $this->db->where('g.group_user', 'teknisi');
        $this->db->where('u.deleted', 0);
        $this->db->where('u.status_user', 1);
        return $this->db->get()->result();
    }
    
    // Assign survey task to technician
    public function assign_survey($data)
    {
        $params = [
            'id_registrasi_customer' => $data['id_registrasi_customer'],
            'id_teknisi' => $data['id_teknisi'],
            'created_by' => $this->session->userdata('id_user')
        ];
        
        $this->db->insert('survey_teknisi', $params);
        
        // Update registration status
        $this->db->set('status_survey', 'proses');
        $this->db->where('id_registrasi_customer', $data['id_registrasi_customer']);
        $this->db->update('registrasi_customer');
        
        return $this->db->affected_rows();
    }
    
    // Get survey assignments for a technician
    public function get_technician_assignments($technician_id)
{
    $this->db->select('st.*, r.nama_lengkap, r.alamat_pemasangan, r.whatsapp, r.jenis_layanan, r.bandwidth, u.nama_user AS nama_teknisi');
    $this->db->select('(SELECT COUNT(*) FROM survey_pelanggan sp WHERE sp.id_survey_teknisi = st.id_survey_teknisi) as survey_completed');
    $this->db->from('survey_teknisi st');
    $this->db->join('registrasi_customer r', 'st.id_registrasi_customer = r.id_registrasi_customer');
    $this->db->join('users u', 'st.id_teknisi = u.id_user');
    $this->db->where('st.id_teknisi', $technician_id);
    
    return $this->db->get()->result();
}

    
    // Get all ODP data
    public function get_all_odp()
    {
        $this->db->select('o.*, w.nama_wilayah, w.kecamatan, w.kabupaten');
        $this->db->from('odp o');
        $this->db->join('wilayah w', 'o.id_wilayah = w.id_wilayah', 'left');
        $this->db->where('o.deleted', 0);
        return $this->db->get()->result();
    }
    
    // Get ODP data by ID
    public function get_odp_by_id($id)
    {
        $this->db->where('id_odp', $id);
        return $this->db->get('odp')->row();
    }
    
    // Get registration data by ID
    public function get_registration_by_id($id)
    {
        $this->db->where('id_registrasi_customer', $id);
        return $this->db->get('registrasi_customer')->row();
    }
    
    // Get survey task by ID
    public function get_survey_task_by_id($id)
    {
        $this->db->select('st.*, r.*');
        $this->db->from('survey_teknisi st');
        $this->db->join('registrasi_customer r', 'st.id_registrasi_customer = r.id_registrasi_customer');
        $this->db->where('st.id_survey_teknisi', $id);
        return $this->db->get()->row();
    }
    
    // Save survey results
    // Save survey results
public function save_survey_result($data)
{
    // Upload photos
    $config['upload_path'] = './uploads/survey/';
    $config['allowed_types'] = 'jpg|png|jpeg';

    $config['file_name'] = 'survey_' . date('YmdHis');
    
    $this->load->library('upload', $config);
    
    // Initialize params
    $params = [
        'id_survey_teknisi' => $data['id_survey_teknisi'],
        'jenis_survey' => $data['jenis_survey'],
        'jarak_rumah_odp' => $data['jarak_rumah_odp'],
        'id_odp' => $data['id_odp'],
        'catatan' => $data['catatan'],
        'status_survey' => $data['status_survey'] ?? 'awal',
        'created_by' => $this->session->userdata('id_user'),
        // Tambahkan deskripsi foto
        'deskripsi_foto_rumah' => $data['deskripsi_foto_rumah'] ?? '',
        'deskripsi_foto_odp' => $data['deskripsi_foto_odp'] ?? '',
        'deskripsi_foto_odp_tersisa' => $data['deskripsi_foto_odp_tersisa'] ?? '',
        'deskripsi_foto_tambahan' => $data['deskripsi_foto_tambahan'] ?? ''
    ];
    
    // If this is a final survey, add cable length
    if (isset($data['status_survey']) && $data['status_survey'] == 'final') {
        $params['panjang_kabel'] = $data['panjang_kabel'];
    }
    
    // Upload house photo
    $this->upload->initialize($config);
    if (!empty($_FILES['foto_rumah']['name'])) {
        if ($this->upload->do_upload('foto_rumah')) {
            $params['foto_rumah'] = $this->upload->data('file_name');
        }
    }
    
    // Upload ODP photo
    $this->upload->initialize($config);
    if (!empty($_FILES['foto_odp']['name'])) {
        if ($this->upload->do_upload('foto_odp')) {
            $params['foto_odp'] = $this->upload->data('file_name');
        }
    }
    
    // Upload remaining ODP photo
    $this->upload->initialize($config);
    if (!empty($_FILES['foto_odp_tersisa']['name'])) {
        if ($this->upload->do_upload('foto_odp_tersisa')) {
            $params['foto_odp_tersisa'] = $this->upload->data('file_name');
        }
    }
    
    // Upload additional photo
    $this->upload->initialize($config);
    if (!empty($_FILES['foto_tambahan']['name'])) {
        if ($this->upload->do_upload('foto_tambahan')) {
            $params['foto_tambahan'] = $this->upload->data('file_name');
        }
    }
    
    // Insert survey result
    $this->db->insert('survey_pelanggan', $params);
    
    // Update survey status in survey_teknisi
    $this->db->set('status_survey', 'completed');
    $this->db->where('id_survey_teknisi', $data['id_survey_teknisi']);
    $this->db->update('survey_teknisi');
    
    // Update registration status
    $this->db->set('status_survey', 'selesai');
    $this->db->where('id_registrasi_customer', $data['id_registrasi_customer']);
    $this->db->update('registrasi_customer');
    
    return $this->db->affected_rows();
}
public function update_survey_result($data)
{
    // Check for old ODP ID to handle ODP capacity changes
    $this->db->where('id_survey_pelanggan', $data['id_survey_pelanggan']);
    $old_survey = $this->db->get('survey_pelanggan')->row();
    $old_odp_id = $old_survey->id_odp;
    
    // Initialize params for update
    $params = [
        'jenis_survey' => $data['jenis_survey'],
        'jarak_rumah_odp' => $data['jarak_rumah_odp'],
        'id_odp' => $data['id_odp'],
        'catatan' => $data['catatan'],
        'status_survey' => $data['status_survey'],
        'updated_by' => $this->session->userdata('id_user'),
        'updated_at' => date('Y-m-d H:i:s'),
        // Update deskripsi foto
        'deskripsi_foto_rumah' => $data['deskripsi_foto_rumah'] ?? $old_survey->deskripsi_foto_rumah,
        'deskripsi_foto_odp' => $data['deskripsi_foto_odp'] ?? $old_survey->deskripsi_foto_odp,
        'deskripsi_foto_odp_tersisa' => $data['deskripsi_foto_odp_tersisa'] ?? $old_survey->deskripsi_foto_odp_tersisa,
        'deskripsi_foto_tambahan' => $data['deskripsi_foto_tambahan'] ?? $old_survey->deskripsi_foto_tambahan
    ];
    
    // If this is a final survey, update cable length
    if ($data['status_survey'] == 'final') {
        $params['panjang_kabel'] = $data['panjang_kabel'];
    }
    
    // Upload configuration
    $config['upload_path'] = './uploads/survey/';
    $config['allowed_types'] = 'jpg|png|jpeg';
    
    $config['file_name'] = 'survey_' . date('YmdHis');
    
    $this->load->library('upload', $config);
    
    // Upload house photo
    if (!empty($_FILES['foto_rumah']['name'])) {
        $this->upload->initialize($config);
        if ($this->upload->do_upload('foto_rumah')) {
            $params['foto_rumah'] = $this->upload->data('file_name');
            // Delete old file if exists
            if (!empty($data['old_foto_rumah']) && file_exists('./uploads/survey/' . $data['old_foto_rumah'])) {
                unlink('./uploads/survey/' . $data['old_foto_rumah']);
            }
        }
    }
    
    // Upload ODP photo
    if (!empty($_FILES['foto_odp']['name'])) {
        $this->upload->initialize($config);
        if ($this->upload->do_upload('foto_odp')) {
            $params['foto_odp'] = $this->upload->data('file_name');
            // Delete old file if exists
            if (!empty($data['old_foto_odp']) && file_exists('./uploads/survey/' . $data['old_foto_odp'])) {
                unlink('./uploads/survey/' . $data['old_foto_odp']);
            }
        }
    }
    
    // Upload remaining ODP photo
    if (!empty($_FILES['foto_odp_tersisa']['name'])) {
        $this->upload->initialize($config);
        if ($this->upload->do_upload('foto_odp_tersisa')) {
            $params['foto_odp_tersisa'] = $this->upload->data('file_name');
            // Delete old file if exists
            if (!empty($data['old_foto_odp_tersisa']) && file_exists('./uploads/survey/' . $data['old_foto_odp_tersisa'])) {
                unlink('./uploads/survey/' . $data['old_foto_odp_tersisa']);
            }
        }
    }
    
    // Upload additional photo
    if (!empty($_FILES['foto_tambahan']['name'])) {
        $this->upload->initialize($config);
        if ($this->upload->do_upload('foto_tambahan')) {
            $params['foto_tambahan'] = $this->upload->data('file_name');
            // Delete old file if exists
            if (!empty($data['old_foto_tambahan']) && file_exists('./uploads/survey/' . $data['old_foto_tambahan'])) {
                unlink('./uploads/survey/' . $data['old_foto_tambahan']);
            }
        }
    }
    
    // Update survey data
    $this->db->where('id_survey_pelanggan', $data['id_survey_pelanggan']);
    $update_result = $this->db->update('survey_pelanggan', $params);
    
    // Handle ODP usage if ODP changed
    if ($update_result && $old_odp_id != $data['id_odp']) {
        // Decrease usage for old ODP
        if (!empty($old_odp_id)) {
            $this->update_odp_usage($old_odp_id, false);
        }
        
        // Increase usage for new ODP
        if (!empty($data['id_odp'])) {
            $this->update_odp_usage($data['id_odp'], true);
        }
    }
    
    return $update_result;
}
    public function get_surveyed_customers()
    {
        $this->db->select('r.*, sp.jenis_survey, sp.jarak_rumah_odp, sp.panjang_kabel, sp.foto_rumah, sp.foto_odp, sp.catatan, o.nama_odp');
        $this->db->from('registrasi_customer r');
        $this->db->join('survey_teknisi st', 'r.id_registrasi_customer = st.id_registrasi_customer');
        $this->db->join('survey_pelanggan sp', 'st.id_survey_teknisi = sp.id_survey_teknisi', 'left');
        $this->db->join('odp o', 'sp.id_odp = o.id_odp', 'left');
        $this->db->where('r.status_survey', 'selesai');
        return $this->db->get()->result();
    }
    
    
    public function get_survey_data_by_customer_id($id)
{
    $this->db->select('sp.*, 
                        o.nama_odp, 
                        u.nama_user, 
                        u.nama_user AS nama_teknisi, 
                        updater.nama_user AS updated_by_name'); // Ambil nama user dari updated_by
    $this->db->from('survey_pelanggan sp');
    $this->db->join('survey_teknisi st', 'sp.id_survey_teknisi = st.id_survey_teknisi');
    $this->db->join('users u', 'st.id_teknisi = u.id_user');
    $this->db->join('users updater', 'sp.updated_by = updater.id_user', 'left'); // Join untuk updated_by
    $this->db->join('odp o', 'sp.id_odp = o.id_odp', 'left');
    $this->db->where('st.id_registrasi_customer', $id);

    return $this->db->get()->row();
}

    // Add ODP data
    public function add_odp($data)
    {
        $params = [
            'nama_odp' => $data['nama_odp'],
            'kapasitas' => $data['kapasitas'],
            'terpakai' => $data['terpakai'] ?? 0,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'id_wilayah' => $data['id_wilayah'],
            'alamat' => $data['alamat'],
            'created_by' => $this->session->userdata('id_user')
        ];
        
        $this->db->insert('odp', $params);
        return $this->db->affected_rows();
    }
    
    // Update ODP usage
    public function update_odp_usage($id_odp, $increment = true)
    {
        $this->db->set('terpakai', 'terpakai ' . ($increment ? '+' : '-') . ' 1', false);
        $this->db->where('id_odp', $id_odp);
        $this->db->update('odp');
        return $this->db->affected_rows();
    }
    public function get_survey_assignment($id_registrasi_customer)
{
    $this->db->select('st.*, 
                       u.nama_user AS nama_teknisi, 
                       u.phone_user, 
                       penugas.nama_user AS nama_penugas,
                       (SELECT COUNT(*) 
                        FROM survey_pelanggan sp 
                        WHERE sp.id_survey_teknisi = st.id_survey_teknisi) as survey_completed');
    $this->db->from('survey_teknisi st');
    $this->db->join('users u', 'st.id_teknisi = u.id_user');
    $this->db->join('users penugas', 'st.created_by = penugas.id_user', 'left');
    $this->db->where('st.id_registrasi_customer', $id_registrasi_customer);
    return $this->db->get()->row();
}

public function update_survey_assignment($data)
{
    $params = [
        'id_teknisi' => $data['id_teknisi'],
        'catatan' => $data['catatan'] ?? null,
        'updated_by' => $this->session->userdata('id_user'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $this->db->where('id_survey_teknisi', $data['id_survey_teknisi']);
    $this->db->update('survey_teknisi', $params);
    
    return $this->db->affected_rows();
}
public function get_filtered_customers($status = null, $layanan = null, $kecamatan = null, $bandwidth = null, $teknisi = null, $search = null)
{
    $this->db->select('r.*, w.nama_wilayah, w.kecamatan as kecamatan_name, w.kabupaten');
    $this->db->from('registrasi_customer r');
    $this->db->join('wilayah w', 'r.kecamatan = w.kecamatan', 'left');
    
    // Apply filters
    if ($status !== null && $status !== '') {
        $this->db->where('r.status_survey', $status);
    }
    
    if ($layanan !== null && $layanan !== '') {
        $this->db->where('r.jenis_layanan', $layanan);
    }
    
    if ($kecamatan !== null && $kecamatan !== '') {
        $this->db->where('r.kecamatan', $kecamatan);
    }
    
    if ($bandwidth !== null && $bandwidth !== '') {
        $this->db->where('r.bandwidth', $bandwidth);
    }
    
    if ($teknisi !== null && $teknisi !== '') {
        $this->db->join('survey_teknisi st', 'r.id_registrasi_customer = st.id_registrasi_customer');
        $this->db->where('st.id_teknisi', $teknisi);
    }
    
    if ($search !== null && $search !== '') {
        $this->db->group_start();
        $this->db->like('r.nama_lengkap', $search);
        $this->db->or_like('r.nomor_registrasi', $search);
        $this->db->or_like('r.alamat_pemasangan', $search);
        $this->db->group_end();
    }
    
    $this->db->order_by('r.no_urut_registrasi', 'desc');
    return $this->db->get()->result();
}
}