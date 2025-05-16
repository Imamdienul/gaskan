<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instalasi_m extends CI_Model
{

    public function get_unsurveyed_customers()
    {
        $this->db->select('rc.*, w.nama_wilayah, w.kecamatan, w.kabupaten');
        $this->db->from('registrasi_customer rc');
        $this->db->join('wilayah w', 'rc.kecamatan = w.kecamatan', 'left');
        
        $this->db->order_by('no_urut_registrasi', 'desc');

        return $this->db->get()->result();
    }

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


    public function get_all_customer()
    {
        $this->db->select('rc.*');
        $this->db->from('registrasi_customer rc');
        $this->db->where('rc.status_survey', 'selesai');
        return $this->db->get()->result();
    }

    public function get_all_area()
    {
        $this->db->select('w.id_wilayah, w.nama_wilayah');
        $this->db->from('wilayah w');
        return $this->db->get()->result();
    }

    public function get_all_paket()
    {
        $this->db->select('p.id_paket, p.nama_paket');
        $this->db->from('paket p');
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
    
    // Get activation task by ID
    public function get_activation_task_by_id($id)
    {
        $this->db->select('at.*, rc.*');
        $this->db->from('instalasi_teknisi at');
        $this->db->join('registrasi_customer rc', 'at.id_registrasi_customer = rc.id_registrasi_customer');
        $this->db->where('at.id_instalasi_teknisi', $id);
        
        
        return $this->db->get()->row();
    }
    
    // Assign activation task to technician
    public function assign_activation($data)
    {
        $params = [
            'id_registrasi_customer' => $data['id_registrasi_customer'],
            'id_teknisi' => $data['id_teknisi'],
            'catatan' => $data['catatan'],
            'created_by' => $this->session->userdata('id_user')
        ];
        
        $this->db->insert('instalasi_teknisi', $params);
        
        // Update registration status
        $this->db->set('status_instalasi', 'proses');
        $this->db->where('id_registrasi_customer', $data['id_registrasi_customer']);
        $this->db->update('registrasi_customer');
        
        
        return $this->db->affected_rows();
    }
    
    // Get activation assignments for an admin
    public function get_technician_assignments($technician_id)
    {
        $this->db->select('at.*, rc.nama_lengkap, rc.alamat_pemasangan, rc.whatsapp, rc.jenis_layanan, rc.bandwidth, u.nama_user AS nama_teknisi');
        $this->db->select('(SELECT COUNT(*) FROM instalasi_instalasi ai WHERE ai.id_teknisi = at.id_teknisi AND at.status_instalasi = "completed") as activation_completed');
        $this->db->from('instalasi_teknisi at');
        $this->db->join('registrasi_customer rc', 'at.id_registrasi_customer = rc.id_registrasi_customer');
        $this->db->join('users u', 'u.id_user = '. $technician_id);
        $this->db->where('at.id_teknisi', $technician_id);
        $this->db->order_by('created_date', 'DESC');
        
        
        return $this->db->get()->result();
    }

    public function get_technician_assignments_list_activation($technician_id)
    {
        $this->db->select('at.*, rc.nama_lengkap, rc.alamat_pemasangan, rc.whatsapp, w.nama_wilayah, p.nama_paket, u.nama_user AS id_teknisi');
        $this->db->from('instalasi_teknisi at');
        $this->db->join('registrasi_customer rc', 'at.id_registrasi_customer = rc.id_registrasi_customer');
        $this->db->join('wilayah w', 'at.id_area = w.id_wilayah');
        $this->db->join('paket p', 'at.id_paket = p.id_paket');
        $this->db->join('users u', 'u.id_user = '. $technician_id);
        $this->db->where('at.id_teknisi', $technician_id);
        
        
        
        return $this->db->get()->result();
    }

    public function get_activation_data_by_customer_id_old($id)
    {
        $this->db->cache_off();
        $this->db->select('ai.*, 
                            w.nama_wilayah, 
                            p.nama_paket,
                            u.nama_user, 
                            u.nama_user AS nama_teknisi'); // Ambil nama user dari updated_by');
        $this->db->from('instalasi_instalasi ai');
        $this->db->join('users u', 'ai.id_teknisi = u.id_user');
        $this->db->join('wilayah w', 'w.id_wilayah = ai.id_area', 'left');
        $this->db->join('paket p', 'ai.id_paket = p.id_paket', 'left');
        $this->db->where('ai.id_instalasi', $id);
        
        
    
        return $this->db->get()->row();
    }

    public function get_data_customer($id)
    {
        $this->db->select('rc.alamat_pemasangan, rc.whatsapp');
        $this->db->from('registrasi_customer rc');
        $this->db->where('rc.id_registrasi_customer', $id);
        
    
        return $this->db->get()->result();
    }

    public function get_customer_id($id)
    {
        $this->db->select('ai.id_registrasi_customer');
        $this->db->from('instalasi_instalasi ai');
        $this->db->where('ai.id_instalasi', $id);
    
        return $this->db->get()->row_array();
    }
    
    // Save activation results
    public function save_instalasi($data)
    {
        // Config untuk upload foto
        $config['upload_path'] = './uploads/instalasi/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['file_name'] = 'instalasi_' . date('dHis');
    
        $this->load->library('upload', $config);
        
        // Persiapkan data untuk tabel instalasi_instalasi
        $data = [
            'id_teknisi' => $data['id_teknisi'],
            'tgl_pasang' => $data['tgl_pasang'],
            'waktu_pasang' => $data['waktu_pasang'],
            'id_area' => $data['id_area'],
            'id_registrasi_customer' => $data['id_registrasi_customer'],
            'id_paket' => $data['id_paket'],
            'id_odp' => $data['odp'],
            'port_odp' => $data['port_odp'],
            'panjang_kabel' => $data['panjang_kabel'],
            'nomor_roll_kabel' => $data['nomor_roll_kabel'],
            'merk_modem' => $data['merk_modem'],
            'tipe_modem' => $data['tipe_modem'],
            'sn_modem' => $data['sn_modem'],
            'mac_address' => $data['mac_address'],
            'redaman_pelanggan' => $data['redaman_pelanggan'],
            'status_instalasi' => 'completed',
            'catatan' => isset($data['catatan']) ? $data['catatan'] : '',
            'deskripsi_foto_koneksi_odp' => isset($data['deskripsi_foto_koneksi']) ? $data['deskripsi_foto_koneksi'] : null,
            'deskripsi_foto_redaman_pelanggan' => isset($data['deskripsi_foto_redaman']) ? $data['deskripsi_foto_redaman'] : null,
            'deskripsi_foto_instalasi' => isset($data['deskripsi_foto_instalasi']) ? $data['deskripsi_foto_instalasi'] : null,
            'deskripsi_foto_rumah' => isset($data['deskripsi_foto_rumah']) ? $data['deskripsi_foto_rumah'] : null,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('id_user')
        ];
        
        // Upload foto koneksi ODP
        $this->upload->initialize($config);
        if (!empty($_FILES['foto_koneksi_odp']['name'])) {
            if ($this->upload->do_upload('foto_koneksi_odp')) {
                $data['foto_koneksi_odp'] = $this->upload->data('file_name');
            }
        }
        
        // Upload foto redaman pelanggan
        $this->upload->initialize($config);
        if (!empty($_FILES['foto_redaman_pelanggan']['name'])) {
            if ($this->upload->do_upload('foto_redaman_pelanggan')) {
                $data['foto_redaman_pelanggan'] = $this->upload->data('file_name');
            }
        }
        
        // Upload foto instalasi
        $this->upload->initialize($config);
        if (!empty($_FILES['foto_instalasi']['name'])) {
            if ($this->upload->do_upload('foto_instalasi')) {
                $data['foto_instalasi'] = $this->upload->data('file_name');
            }
        }

        // Upload foto rumah
        $this->upload->initialize($config);
        if (!empty($_FILES['foto_rumah']['name'])) {
            if ($this->upload->do_upload('foto_rumah')) {
                $data['foto_rumah'] = $this->upload->data('file_name');
            }
        }
        
        // Insert data instalasi
        $this->db->insert('instalasi_instalasi',$data);
    
        // Update survey status in instalasi_teknisi
        $this->db->set('status_instalasi', 'completed');
        $this->db->where('id_teknisi', $data['id_teknisi']);
        $this->db->update('instalasi_teknisi');
        
        // Update registration status
        $this->db->set('status_instalasi', 'selesai');
        $this->db->where('id_registrasi_customer', $data['id_registrasi_customer']);
        $this->db->update('registrasi_customer');
        
        return $this->db->affected_rows();
    }

    public function approve_instalasi($id)
    {
        $this->db->set('status_instalasi', 'completed');
        $this->db->where('id_instalasi', decrypt_url($id));
        $this->db->update('instalasi_instalasi');
        
        return $this->db->trans_status();
    }

    public function update_activation_result($data)
    {
        // Config untuk upload foto
        $config['upload_path'] = './uploads/instalasi/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['file_name'] = 'instalasi_' . date('dHis');
    
        $this->load->library('upload', $config);

        // Persiapkan data untuk tabel instalasi_instalasi
        $params = [
            'id_instalasi' => $data['id_instalasi'],
            'id_teknisi' => $data['id_teknisi'],
            'tgl_pasang' => $data['tgl_pasang'],
            'waktu_pasang' => $data['waktu_pasang'],
            'id_area' => $data['id_area'],
            'id_registrasi_customer' => $data['id_pelanggan'],
            'id_paket' => $data['id_paket'],
            'id_odp' => $data['id_odp'],
            'port_odp' => $data['port_odp'],
            'panjang_kabel' => $data['panjang_kabel'],
            'nomor_roll_kabel' => $data['nomor_roll_kabel'],
            'merk_modem' => $data['merk_modem'],
            'tipe_modem' => $data['tipe_modem'],
            'sn_modem' => $data['sn_modem'],
            'mac_address' => $data['mac_address'],
            'catatan' => $data['catatan'],
            'redaman_pelanggan' => $data['redaman_pelanggan'],
            'deskripsi_foto_koneksi_odp' => isset($data['deskripsi_foto_koneksi']) ? $data['deskripsi_foto_koneksi'] : null,
            'deskripsi_foto_redaman_pelanggan' => isset($data['deskripsi_foto_redaman']) ? $data['deskripsi_foto_redaman'] : null,
            'deskripsi_foto_instalasi' => isset($data['deskripsi_foto_instalasi']) ? $data['deskripsi_foto_instalasi'] : null,
            'deskripsi_foto_rumah' => isset($data['deskripsi_foto_rumah']) ? $data['deskripsi_foto_rumah'] : null,
            'updated_date' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('id_user')
        ];
        
        // Upload foto koneksi ODP
        $this->upload->initialize($config);
        if (!empty($_FILES['foto_koneksi_odp']['name'])) {
            if ($this->upload->do_upload('foto_koneksi_odp')) {
                $params['foto_koneksi_odp'] = $this->upload->data('file_name');
            }
        }
        
        // Upload foto redaman pelanggan
        $this->upload->initialize($config);
        if (!empty($_FILES['foto_redaman']['name'])) {
            if ($this->upload->do_upload('foto_redaman_pelanggan')) {
                $params['foto_redaman_pelanggan'] = $this->upload->data('file_name');
            }
        }
        
        // Upload foto instalasi
        $this->upload->initialize($config);
        if (!empty($_FILES['foto_instalasi']['name'])) {
            if ($this->upload->do_upload('foto_instalasi')) {
                $params['foto_instalasi'] = $this->upload->data('file_name');
            }
        }

        // Upload foto rumah
        $this->upload->initialize($config);
        if (!empty($_FILES['foto_rumah']['name'])) {
            if ($this->upload->do_upload('foto_rumah')) {
                $params['foto_rumah'] = $this->upload->data('file_name');
            }
        }
        
        // Update instalasi data
        $this->db->where('id_instalasi', $params['id_instalasi']);
        $this->db->update('instalasi_instalasi', $params);
        
        // Selesai transaksi
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
    
    public function delete_activation($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id_instalasi', $id);
        $this->db->update('instalasi_instalasi');
    }

    public function get_activated_customers()
{
    $this->db->select('rc.*, ai.*, o.nama_odp, p.nama_paket, w.nama_wilayah');
    $this->db->from('registrasi_customer rc');
    $this->db->join('instalasi_teknisi at', 'rc.id_registrasi_customer = at.id_registrasi_customer');
    $this->db->join('instalasi_instalasi ai', 'rc.id_registrasi_customer = ai.id_registrasi_customer', 'left');
    $this->db->join('odp o', 'ai.id_odp = o.id_odp', 'left');
    $this->db->join('wilayah w', 'ai.id_area = w.id_wilayah', 'left');
    $this->db->join('paket p', 'ai.id_paket = p.id_paket', 'left');
    $this->db->where('rc.status_survey', 'selesai');
    $this->db->group_by('rc.id_registrasi_customer');
    return $this->db->get()->result();
}

    public function get_activation_data_by_customer_id($id)
    {
        // $this->db->select('ai.*, 
        //                     p.nama_paket,
        //                     w.nama_wilayah,
        //                     o.nama_odp, 
        //                     u.nama_user, 
        //                     u.nama_user AS nama_teknisi, 
        //                     updater.nama_user AS updated_by_name'); // Ambil nama user dari updated_by
        // $this->db->from('instalasi_instalasi ai');
        // $this->db->join('instalasi_teknisi at', 'ai.id_teknisi = at.id_teknisi');
        // $this->db->join('users u', 'at.id_teknisi = u.id_user');
        // $this->db->join('users updater', 'ai.updated_by = updater.id_user', 'left'); // Join untuk updated_by
        // $this->db->join('odp o', 'ai.id_odp = o.id_odp', 'left');
        // $this->db->join('wilayah w', 'ai.id_area = w.id_wilayah', 'left');
        // $this->db->join('paket p', 'ai.id_area = w.id_wilayah', 'left');
        // $this->db->where('ai.id_instalasi', $id);


        $this->db->select('ai.*, 
                            p.nama_paket,
                            w.nama_wilayah,
                            o.nama_odp, 
                            u.nama_user, 
                            u.nama_user AS nama_teknisi, 
                            updater.nama_user AS updated_by_name'); // Ambil nama user dari updated_by
        $this->db->from('instalasi_instalasi ai');
        $this->db->join('instalasi_teknisi at', 'at.id_teknisi = ai.id_teknisi');
        $this->db->join('users u', 'u.id_user = at.id_teknisi');
        $this->db->join('users updater', 'updater.id_user = ai.updated_by', 'left'); // Join untuk updated_by
        $this->db->join('odp o', 'o.id_odp = ai.id_odp', 'left');
        $this->db->join('wilayah w', 'w.id_wilayah = ai.id_area', 'left');
        $this->db->join('paket p', 'p.id_paket = ai.id_paket', 'left');
        $this->db->where('ai.id_registrasi_customer', $id);


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

    public function get_activation_assignment($id_registrasi_customer)
    {
        $this->db->select('at.*, u.nama_user AS nama_teknisi, u.phone_user, 
                        (SELECT COUNT(*) FROM instalasi_instalasi ai WHERE ai.id_teknisi = at.id_teknisi) as activation_completed');
        $this->db->from('instalasi_teknisi at');
        $this->db->join('users u', 'at.id_teknisi = u.id_user');
        $this->db->where('at.id_registrasi_customer', $id_registrasi_customer);
        return $this->db->get()->row();
    }

    public function update_activation_assignment($data)
    {
        $params = [
            'id_teknisi' => $data['id_teknisi'],
            'catatan' => $data['catatan'] ?? null,
            'updated_by' => $this->session->userdata('id_user'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id_instalasi_teknisi', $data['id_instalasi_teknisi']);
        $this->db->update('instalasi_teknisi', $params);
        
        return $this->db->affected_rows();
    }
}