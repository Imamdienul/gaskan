<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah extends CI_Model
{
    public function get_all_provinsi()
    {
        $this->db->select('*');
        $this->db->from('wilayah_provinsi');
        $this->db->order_by('nama', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_kabupaten_by_provinsi($provinsi_id)
    {
        $this->db->select('*');
        $this->db->from('wilayah_kabupaten');
        $this->db->where('provinsi_id', $provinsi_id);
        $this->db->order_by('nama', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_kecamatan_by_kabupaten($kabupaten_id)
    {
        $this->db->select('*');
        $this->db->from('wilayah_kecamatan');
        $this->db->where('kabupaten_id', $kabupaten_id);
        $this->db->order_by('nama', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_desa_by_kecamatan($kecamatan_id)
    {
        $this->db->select('*');
        $this->db->from('wilayah_desa');
        $this->db->where('kecamatan_id', $kecamatan_id);
        $this->db->order_by('nama', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_nama_provinsi($provinsi_id)
    {
        $this->db->select('nama');
        $this->db->from('wilayah_provinsi');
        $this->db->where('id', $provinsi_id);
        $query = $this->db->get();
        return $query->row()->nama;
    }

    public function get_nama_kabupaten($kabupaten_id)
    {
        $this->db->select('nama');
        $this->db->from('wilayah_kabupaten');
        $this->db->where('id', $kabupaten_id);
        $query = $this->db->get();
        return $query->row()->nama;
    }

    public function get_nama_kecamatan($kecamatan_id)
    {
        $this->db->select('nama');
        $this->db->from('wilayah_kecamatan');
        $this->db->where('id', $kecamatan_id);
        $query = $this->db->get();
        return $query->row()->nama;
    }

    public function get_nama_desa($desa_id)
    {
        $this->db->select('nama');
        $this->db->from('wilayah_desa');
        $this->db->where('id', $desa_id);
        $query = $this->db->get();
        return $query->row()->nama;
    }
}