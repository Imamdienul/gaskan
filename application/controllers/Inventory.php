<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_role_administrator_and_admin_officer();
        $this->load->model(['Master_barang_m', 'Master_merek_m', 'Log_m', 'Master_tipe_m', 'Inventory_m', 'Mutasi_m']);
        $this->load->helper('Rupiah');
    }

    public function index()
    {
        $inventory = $this->Inventory_m;
        $validation = $this->form_validation;
        $validation->set_rules($inventory->rules_inventory());
        if ($validation->run() == FALSE) {
            $data['stok'] = $this->Inventory_m->get_total_by_type();
            $data['master_barang'] = $this->Master_barang_m->get_all_master_barang();
            $data['master_tipe'] = $this->Master_tipe_m->get_all_master_tipe();
            $data['inventory'] = $inventory->get_all_stok_inventory();
            $this->template->load('shared/index', 'inventory/index', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $inventory->add_inventory($post);
            if ($this->db->affected_rows() > 0) {
                $last_no_regis = $inventory->get_last_inventory();
                $url = base_url('inventory/barcode/') . $last_no_regis;
                $this->Log_m->create_log('insert inventory barang SN ' . $post['fserial_number']);
                $this->session->set_flashdata('pesan', "<div class='alert alert-dismissible alert-default-success'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                                Data Inventory berhasil disimpan, <br> <a href={$url} class='btn btn-sm btn-primary text-white mt-2' target='_blank'><i class='fas fa-print'></i> PRINT BARCODE BARANG TERBARU</a>
                            </div>");
                $this->session->set_flashdata('success', 'Data barang berhasil disimpan!');
                redirect('inventory', 'refresh');
            }
        }
    }
    public function edit($id = null)
    {
        $inventory = $this->Inventory_m;
        $validation = $this->form_validation;
        $validation->set_rules($inventory->rules_update_inventory());
        if ($validation->run() == FALSE) {
            $data['master_barang'] = $this->Master_barang_m->get_all_master_barang();
            $data['master_tipe'] = $this->Master_tipe_m->get_all_master_tipe();
            $data['inventory'] = $inventory->get_all_inventory();
            $data['data'] = $inventory->get_by_id_inventory(decrypt_url($id));
            if ($data['data']) {
                $this->template->load('shared/index', 'inventory/edit', $data);
            } else {
                $this->session->set_flashdata('warning', 'Data inventory tidak ditemukan!');
                redirect('inventory', 'refresh');
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $inventory->update_inventory($id, $post);
            if ($this->db->affected_rows() > 0) {
                $this->Log_m->create_log('update data inventory barang no regis ' . $post['fno_registrasi']);
                $this->session->set_flashdata('success', 'Update data barang berhasil!');
                redirect('inventory', 'refresh');
            } else {
                $this->session->set_flashdata('warning', 'Update data barang dibatalkan!');
                redirect('inventory', 'refresh');
            }
        }
    }
    public function edit_master_tipe($id = null)
    {
        $tipe = $this->Master_tipe_m;
        $validation = $this->form_validation;
        $validation->set_rules($tipe->rules_update_master_tipe());
        if ($validation->run() == FALSE) {
            $data['master_tipe'] = $this->Master_tipe_m->get_all_master_tipe();
            $data['master_merek'] = $this->Master_merek_m->get_all_master_merek();
            $data['data'] = $tipe->get_by_id_master_tipe(decrypt_url($id));
            if ($data['data']) {
                $this->template->load('shared/index', 'inventory/edit_master_tipe', $data);
            } else {
                $this->session->set_flashdata('warning', 'Data tidak ditemukan!');
                redirect('inventory/master_tipe', 'refresh');
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $tipe->update_master_tipe(decrypt_url($id), $post);
            if ($this->db->affected_rows() > 0) {
                $this->Log_m->create_log('update data master tipe ' . $post['fkode_tipe']);
                $this->session->set_flashdata('success', 'Update data berhasil!');
                redirect('inventory/master_tipe', 'refresh');
            } else {
                $this->session->set_flashdata('warning', 'Tidak ada data yang diupdate!');
                redirect('inventory/master_tipe', 'refresh');
            }
        }
    }
    public function delete_inventory($id)
    {
        $this->Inventory_m->delete_inventory(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->Log_m->create_log('delete inventory ' . decrypt_url($id));
            $this->session->set_flashdata('success', 'Data inventory berhasil dihapus!');
            redirect('inventory', 'refresh');
        }
    }
    function barcode($id = null)
    {

        include_once APPPATH . '/third_party/fpdf/fpdf.php';
        if ($id == null) {
            $this->session->set_flashdata('warning', 'ID tidak ditemukan');
            redirect('inventory', 'refresh');
        } else {
            $data['id'] = $id;
            $data['data'] = $this->Inventory_m->get_by_no_registrasi($id);
            $this->load->view('inventory/barcode_pdf', $data);
        }
    }
    function barcode_multi()
    {

        include_once APPPATH . '/third_party/fpdf/fpdf.php';
        $noreg = $_POST['noreg'];
        $data['data'] = $this->Inventory_m->get_all_by_no_registrasi($noreg);
        $this->load->view('inventory/barcode_multi_pdf', $data);
    }

    public function master_barang()
    {
        $master_barang = $this->Master_barang_m;
        $validation = $this->form_validation;
        $validation->set_rules($master_barang->rules_master_barang());
        if ($validation->run() == FALSE) {
            $data['master_barang'] = $this->Master_barang_m->get_all_master_barang();
            $data['no_urut'] = $this->Master_barang_m->get_no_urut_barang();
            $this->template->load('shared/index', 'inventory/master_barang', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $master_barang->add_master_barang($post);
            $item = $post['fkode_barang'];
            if ($this->db->affected_rows() > 0) {
                $this->Log_m->create_log('insert master barang ' . $item);
                $this->session->set_flashdata('success', 'Data master barang berhasil disimpan!');
                redirect('inventory/master_barang', 'refresh');
            }
        }
    }
    public function delete_master_barang($id)
    {
        $id_brg = decrypt_url($id);
        $this->Master_barang_m->delete_master_barang($id_brg);
        if ($this->db->affected_rows() > 0) {
            $this->Log_m->create_log('delete master barang id ' . $id_brg);
            $this->session->set_flashdata('success', 'Data master barang berhasil dihapus!');
            redirect('inventory/master_barang', 'refresh');
        }
    }
    public function master_merek()
    {
        $master_merek = $this->Master_merek_m;
        $validation = $this->form_validation;
        $validation->set_rules($master_merek->rules_master_merek());
        if ($validation->run() == FALSE) {
            $data['master_merek'] = $this->Master_merek_m->get_all_master_merek();
            $data['no_urut'] = $this->Master_merek_m->get_no_urut_merek();
            $this->template->load('shared/index', 'inventory/master_merek', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $master_merek->add_master_merek($post);
            if ($this->db->affected_rows() > 0) {
                $this->Log_m->create_log('insert master merek ' . $post['fkode_merek']);
                $this->session->set_flashdata('success', 'Data master merek berhasil disimpan!');
                redirect('inventory/master_merek', 'refresh');
            }
        }
    }
    public function delete_master_merek($id)
    {
        $this->Master_merek_m->delete_master_merek(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->Log_m->create_log('delete master merek id ' . decrypt_url($id));
            $this->session->set_flashdata('success', 'Data master merek berhasil dihapus!');
            redirect('inventory/master_merek', 'refresh');
        }
    }
    public function master_tipe()
    {
        $master_tipe = $this->Master_tipe_m;
        $validation = $this->form_validation;
        $validation->set_rules($master_tipe->rules_master_tipe());
        if ($validation->run() == FALSE) {
            $data['master_tipe'] = $this->Master_tipe_m->get_all_master_tipe();
            $data['master_merek'] = $this->Master_merek_m->get_all_master_merek();
            $data['no_urut'] = $this->Master_tipe_m->get_no_urut_tipe();
            $this->template->load('shared/index', 'inventory/master_tipe', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $master_tipe->add_master_tipe($post);
            if ($this->db->affected_rows() > 0) {
                $this->Log_m->create_log('insert master tipe barang kode ' . $post['fkode_tipe']);
                $this->session->set_flashdata('success', 'Data master tipe barang berhasil disimpan!');
                redirect('inventory/master_tipe', 'refresh');
            }
        }
    }
    public function delete_master_tipe($id)
    {
        $this->Master_tipe_m->delete_master_tipe(decrypt_url($id));
        if ($this->db->affected_rows() > 0) {
            $this->Log_m->create_log('delete master tipe id ' . decrypt_url($id));
            $this->session->set_flashdata('success', 'Data master tipe barang berhasil dihapus!');
            redirect('inventory/master_tipe', 'refresh');
        }
    }

    public function show_mutasi($noregis)
    {
        $data = $this->Mutasi_m->get_mutasi_by_no_registrasi($noregis);
        if ($data) { ?>
            <div class="card-header">
                <div class="card-title">
                    MUTASI BARANG [<?= $noregis ?>]
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">

                    <thead>
                        <tr>
                            <th scope="col">NO MUTASI</th>
                            <th scope="col">TGL MUTASI</th>
                            <th scope="col">LOKASI</th>
                            <th scope="col">NOTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $key) : ?>
                            <tr>
                                <th scope="row"><?= $key->no_mutasi ?></th>
                                <td><?= TanggalIndo($key->tgl_mutasi) ?></td>
                                <td><?= strtoupper($key->lokasi_barang)  ?></td>
                                <td><?= strtoupper($key->note) ?></td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>

            </div>
        <?php } else { ?>
            <div class="card-header">
                <div class="card-title">
                    MUTASI BARANG [<?= $noregis ?>]
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <p class="text-center">Belum ada mutasi</p>
            </div>
        <?php } ?>


<?php }
}

/* End of file Inventory.php */
