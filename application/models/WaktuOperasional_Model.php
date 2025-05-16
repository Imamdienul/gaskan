<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WaktuOperasional_Model extends CI_Model {
    public function waktuoperasional() {
        return $this->get_all_waktu_operasional();
    }

    public function get_all_waktu_operasional() {
        $this->db->select('*');
        $this->db->from('waktu_operasional');
        $query = $this->db->get();
        return $query->result();
    }

    public function update_waktu_operasional($day, $waktu_masuk, $waktu_keluar) {
        // Update waktu masuk
        $this->db->where('day', $day);
        $this->db->where('keterangan', 'masuk');
        $this->db->update('waktu_operasional', ['waktu_operasional' => $waktu_masuk]);

        // Update waktu keluar
        $this->db->where('day', $day);
        $this->db->where('keterangan', 'keluar');
        $this->db->update('waktu_operasional', ['waktu_operasional' => $waktu_keluar]);
    }
}