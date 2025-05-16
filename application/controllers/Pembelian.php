<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['Pembelian_m', 'Project_m', 'Item_pembelian_m', 'Status_pembelian_m']);
        $this->load->helper(['Rupiah', 'formatdate', 'pembelian', 'project', 'Status_pembelian']);
    }
    public function index()
    {
        $data['pembelian'] = $this->Pembelian_m->get_all_pembelian();
        $this->template->load('shared/index', 'pembelian/index', $data);
    }
    public function delete($id_kasbon) {
        $result = $this->Pembelian_m->delete_by_id($id_kasbon);
        
        if ($result) {
            // Redirect atau memberikan respon sukses
            $this->session->set_flashdata('success', 'Data Pembelian berhasil dihapus!');
            redirect('pembelian', 'refresh');
            
        } else {
            // Menangani error jika penghapusan gagal
            echo "Gagal menghapus data.";
        }
    }
    public function create()
    {

        $pembelian = $this->Pembelian_m;
        $validation = $this->form_validation;
        $validation->set_rules($pembelian->rules());
        if ($validation->run() == FALSE) {
            $data['no_pembelian'] = $this->Pembelian_m->get_no_pembelian();
            $data['no_urut'] = $this->Pembelian_m->get_no_urut_pembelian();
            $data['project'] = $this->Project_m->get_all_project_for_pembelian();
            $this->template->load('shared/index', 'pembelian/create', $data);
        } else {
            $no_urut = $this->Pembelian_m->get_no_urut_pembelian();
            $nopem = strtoupper(sprintf("%04d", $no_urut) . '/PR/' . bulanRomawi(date('m')) . '/' . date('Y'));
            $post = $this->input->post(null, TRUE);
            $pembelian->add_pembelian($nopem, $post);
            if ($this->db->affected_rows() > 0) {
                $nama_barang = $_POST['fnama_barang'];
                $harga_satuan = $_POST['fharga_satuan'];
                $qty = $_POST['fqty'];
                $satuan = $_POST['fsatuan'];
                $spesifikasi = $_POST['fspesifikasi'];
                $note = $_POST['fnote'];
                $data = array();
                $index = 0;
                foreach ($nama_barang as $key) {
                    array_push(
                        $data,
                        array(
                            'nama_barang' => $key,
                            'harga_satuan' => $harga_satuan[$index],
                            'no_pembelian' => $nopem,
                            'qty' => $qty[$index],
                            'satuan' => $satuan[$index],
                            'total_harga' => $harga_satuan[$index] * $qty[$index],
                            'spesifikasi' => $spesifikasi[$index],
                            'note' => $note[$index],
                        )
                    );
                    $index++;
                }
                $sql = $this->Item_pembelian_m->add_item_pembelian($data);
                $this->Status_pembelian_m->add_status_created_pembelian($post);
                if ($sql) {
                    $this->session->set_flashdata('success', 'Data pembelian berhasil disimpan!');
                    redirect('pembelian', 'refresh');
                } else {
                    $this->session->set_flashdata('danger', 'Data pembelian gagal disimpan!');
                    redirect('pembelian/create', 'refresh');
                }
            }
        }
    }
    function detail($id)
    {
        $data = $this->Pembelian_m->get_by_id_pembelian($id);
        $item = $this->Item_pembelian_m->get_item_by_no_pembelian($data->no_pembelian);
        $status = $this->Status_pembelian_m->get_status_by_no_pembelian($data->no_pembelian);
?>
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-success">DATA DOKUMEN</h5>
                <ul class="list-group list-group-flush text-uppercase">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>No. Pembelian</strong>
                        <p class="mb-0">
                            <?= $data->no_pembelian ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Tanggal Pengajuan</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->created_date) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>NIK</strong>
                        <p class="mb-0">
                            <?= $data->nik ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Nama Lengkap</strong>
                        <p class="mb-0">
                            <?= $data->nama_user ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Deadline Pembelian</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->deadline_pembelian) ?>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="text-success">DATA PROJECT</h5>
                <ul class="list-group list-group-flush text-uppercase">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Nama Project</strong>
                        <p class="mb-0">
                            <?= $data->nama_project ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Owner</strong>
                        <p class="mb-0">
                            <?= $data->project_owner ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Deadline</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->project_deadline) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Manager</strong>
                        <p class="mb-0">
                            <?= get_project_manager($data->project_id) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Location</strong>
                        <p class="mb-0">
                            <?= $data->project_location ?>
                        </p>
                    </li>

                </ul>
            </div>

        </div>
        <hr>
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="text-success">DATA BARANG</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NAMA BARANG</th>
                            <th scope="col">SPESIFIKASI</th>
                            <th scope="col">HARGA SATUAN</th>
                            <th scope="col">QTY</th>
                            <th scope="col">SATUAN</th>
                            <th scope="col">TOTAL</th>
                            <th scope="col">NOTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($item as $key) :
                        ?>
                            <tr class="text-uppercase">
                                <th scope="row">
                                    <?= $no++ ?>
                                </th>
                                <td>
                                    <?= $key->nama_barang ?>
                                </td>
                                <td>
                                    <?= $key->spesifikasi ?>
                                </td>
                                <td>
                                    <?= rupiah($key->harga_satuan) ?>
                                </td>
                                <td>
                                    <?= $key->qty ?>
                                </td>
                                <td>
                                    <?= $key->satuan ?>
                                </td>
                                <td>
                                    <?= rupiah($key->total_harga) ?>
                                </td>
                                <td>
                                    <?= $key->note ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot class="bg-secondary">
                        <tr>
                            <th colspan="6" class="text-center">TOTAL PEMBELIAN :</th>
                            <th colspan="2">
                                <?= rupiah(get_total_pembelian_by_no_pembelian($key->no_pembelian)) ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="text-success">STATUS PENGAJUAN</h5>
                <table class="table table-sm mb-5 text-uppercase">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">STATUS</th>
                            <th scope="col">TGL CLOSED</th>
                            <th scope="col">PIC</th>
                            <th scope="col">NOTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($status as $key) :
                        ?>
                            <tr class="text-uppercase <?= $key->status_pembelian == 'created' ? 'table-warning' : '' ?><?= $key->status_pembelian == 'approvedprojectmanager' ? 'table-success' : '' ?><?= $key->status_pembelian == 'rejectedprojectmanager' ? 'table-danger' : '' ?><?= $key->status_pembelian == 'rejectedadministrator' ? 'table-danger' : '' ?><?= $key->status_pembelian == 'approvedadministrator' ? 'table-info' : '' ?>">
                                <td>
                                    <?= $key->status_pembelian ?>
                                </td>
                                <td>
                                    <?= $key->created_date ?>
                                </td>
                                <td>
                                    <?= $key->nama_user ?>
                                </td>
                                <td>
                                    <?= $key->note_status_pembelian ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (get_project_manager($data->project_id) === $this->session->userdata('nama_user')) { ?>
            <a data-toggle="modal" onclick="approveActPm(<?= $data->id_pembelian ?>)" href="#modal_status" class="btn <?= cek_status_pembelian($data->no_pembelian, 1) === 1 ? 'btn-secondary disabled' : 'btn-success' ?>">
                SETUJUI
            </a>
            <a data-toggle="modal" onclick="rejectActPm(<?= $data->id_pembelian ?>)" href="#modal_status" class="btn <?= cek_status_pembelian($data->no_pembelian, 1) === 1 ? 'btn-secondary disabled' : 'btn-danger' ?>">
                TOLAK
            </a>
        <?php } ?>
        <button class="btn btn-primary float-right" id="closemodal">TUTUP</button>
        <script>
            $(document).ready(function() {
                $('#closemodal').click(function() {
                    $('#modal_Detail').modal('hide');
                });
            });
        </script>
    <?php

    }
    function approve_pm($id_pembelian)
    {
        $data = $this->Pembelian_m->get_by_id_pembelian($id_pembelian);
        $item = $this->Item_pembelian_m->get_item_by_no_pembelian($data->no_pembelian);
    ?>


        <div class="row">
            <div class="col-md-6">
                <h5 class="text-success">DATA DOKUMEN</h5>
                <ul class="list-group list-group-flush text-uppercase">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>No. Pembelian</strong>
                        <p class="mb-0">
                            <?= $data->no_pembelian ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Tanggal Pengajuan</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->created_date) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>NIK</strong>
                        <p class="mb-0">
                            <?= $data->nik ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Nama Lengkap</strong>
                        <p class="mb-0">
                            <?= $data->nama_user ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Deadline Pembelian</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->deadline_pembelian) ?>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="text-success">DATA PROJECT</h5>
                <ul class="list-group list-group-flush text-uppercase">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Nama Project</strong>
                        <p class="mb-0">
                            <?= $data->nama_project ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Owner</strong>
                        <p class="mb-0">
                            <?= $data->project_owner ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Deadline</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->project_deadline) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Manager</strong>
                        <p class="mb-0">
                            <?= get_project_manager($data->project_id) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Location</strong>
                        <p class="mb-0">
                            <?= $data->project_location ?>
                        </p>
                    </li>

                </ul>
            </div>

        </div>
        <hr>
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="text-success">DATA BARANG</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NAMA BARANG</th>
                            <th scope="col">SPESIFIKASI</th>
                            <th scope="col">HARGA SATUAN</th>
                            <th scope="col">QTY</th>
                            <th scope="col">SATUAN</th>
                            <th scope="col">TOTAL</th>
                            <th scope="col">NOTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($item as $key) :
                        ?>
                            <tr class="text-uppercase">
                                <th scope="row">
                                    <?= $no++ ?>
                                </th>
                                <td>
                                    <?= $key->nama_barang ?>
                                </td>
                                <td>
                                    <?= $key->spesifikasi ?>
                                </td>
                                <td>
                                    <?= rupiah($key->harga_satuan) ?>
                                </td>
                                <td>
                                    <?= $key->qty ?>
                                </td>
                                <td>
                                    <?= $key->satuan ?>
                                </td>
                                <td>
                                    <?= rupiah($key->total_harga) ?>
                                </td>
                                <td>
                                    <?= $key->note ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot class="bg-secondary">
                        <tr>
                            <th colspan="6" class="text-center">TOTAL PEMBELIAN :</th>
                            <th colspan="2">
                                <?= rupiah(get_total_pembelian_by_no_pembelian($key->no_pembelian)) ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <hr>
        <h4 class="text-success">APPROVE PROJECT MANAGER</h4>
        <form role="form" method="POST" action="<?= base_url('pembelian/process_approve_pm') ?>" autocomplete="off">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
            <input type="hidden" name="fid_kasbon" value="<?= encrypt_url($data->id_pembelian) ?>" style="display: none">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group required">
                        <label class="control-label" for="fno_pembelian">No. Pembelian</label>
                        <input type="text" class="form-control <?= form_error('fno_pembelian') ? 'is-invalid' : '' ?>" id="fno_pembelian" name="fno_pembelian" value="<?= $data->no_pembelian ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required">
                        <label class="control-label" for="ftgl_approve">Tanggal Disetujui</label>
                        <input type="text" class="form-control <?= form_error('ftgl_approve') ? 'is-invalid' : '' ?>" id="ftgl_approve" name="ftgl_approve" value="<?= date('d/m/Y') ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group required">
                <label class="control-label" for="fname_user">Disetujui Oleh</label>
                <input type="text" class="form-control <?= form_error('fname_user') ? 'is-invalid' : '' ?>" id="fname_user" name="fname_user" value="<?= strtoupper($this->session->userdata('nama_user')) ?>" readonly>
            </div>

            </div>
            <div class="form-group ">
                <label for="fnote">Catatan</label>
                <textarea name="fnote" class="form-control <?= form_error('fnote') ? 'is-invalid' : '' ?> text-uppercase" id="fnote"><?= $this->input->post('fnote'); ?></textarea>
                <div class="invalid-feedback">
                    <?= form_error('fnote') ?>
                </div>
            </div>
            <button type="submit" class="btn btn-success float-right mt-2">SETUJUI</button>
            <a href="<?= base_url('pembelian') ?>" class="btn btn-primary">TUTUP</a>
        </form>
    <?php }
    function approve_adm($id_pembelian)
    {
        $data = $this->Pembelian_m->get_by_id_pembelian($id_pembelian);
        $item = $this->Item_pembelian_m->get_item_by_no_pembelian($data->no_pembelian);
    ?>

        <div class="row">
            <div class="col-md-6">
                <h5 class="text-success">DATA DOKUMEN</h5>
                <ul class="list-group list-group-flush text-uppercase">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>No. Pembelian</strong>
                        <p class="mb-0">
                            <?= $data->no_pembelian ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Tanggal Pengajuan</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->created_date) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>NIK</strong>
                        <p class="mb-0">
                            <?= $data->nik ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Nama Lengkap</strong>
                        <p class="mb-0">
                            <?= $data->nama_user ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Deadline Pembelian</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->deadline_pembelian) ?>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="text-success">DATA PROJECT</h5>
                <ul class="list-group list-group-flush text-uppercase">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Nama Project</strong>
                        <p class="mb-0">
                            <?= $data->nama_project ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Owner</strong>
                        <p class="mb-0">
                            <?= $data->project_owner ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Deadline</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->project_deadline) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Manager</strong>
                        <p class="mb-0">
                            <?= get_project_manager($data->project_id) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Location</strong>
                        <p class="mb-0">
                            <?= $data->project_location ?>
                        </p>
                    </li>

                </ul>
            </div>

        </div>
        <hr>
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="text-success">DATA BARANG</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NAMA BARANG</th>
                            <th scope="col">SPESIFIKASI</th>
                            <th scope="col">HARGA SATUAN</th>
                            <th scope="col">QTY</th>
                            <th scope="col">SATUAN</th>
                            <th scope="col">TOTAL</th>
                            <th scope="col">NOTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($item as $key) :
                        ?>
                            <tr class="text-uppercase">
                                <th scope="row">
                                    <?= $no++ ?>
                                </th>
                                <td>
                                    <?= $key->nama_barang ?>
                                </td>
                                <td>
                                    <?= $key->spesifikasi ?>
                                </td>
                                <td>
                                    <?= rupiah($key->harga_satuan) ?>
                                </td>
                                <td>
                                    <?= $key->qty ?>
                                </td>
                                <td>
                                    <?= $key->satuan ?>
                                </td>
                                <td>
                                    <?= rupiah($key->total_harga) ?>
                                </td>
                                <td>
                                    <?= $key->note ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot class="bg-secondary">
                        <tr>
                            <th colspan="6" class="text-center">TOTAL PEMBELIAN :</th>
                            <th colspan="2">
                                <?= rupiah(get_total_pembelian_by_no_pembelian($key->no_pembelian)) ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <hr>
        <h4 class="text-success">APPROVE ADMINISTRATOR</h4>
        <form role="form" method="POST" action="<?= base_url('pembelian/process_approve_adm') ?>" autocomplete="off">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
            <input type="hidden" name="fid_kasbon" value="<?= encrypt_url($data->id_pembelian) ?>" style="display: none">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group required">
                        <label class="control-label" for="fno_pembelian">No. Pembelian</label>
                        <input type="text" class="form-control <?= form_error('fno_pembelian') ? 'is-invalid' : '' ?>" id="fno_pembelian" name="fno_pembelian" value="<?= $data->no_pembelian ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required">
                        <label class="control-label" for="ftgl_approve">Tanggal Disetujui</label>
                        <input type="text" class="form-control <?= form_error('ftgl_approve') ? 'is-invalid' : '' ?>" id="ftgl_approve" name="ftgl_approve" value="<?= date('d/m/Y') ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group required">
                <label class="control-label" for="fname_user">Disetujui Oleh</label>
                <input type="text" class="form-control <?= form_error('fname_user') ? 'is-invalid' : '' ?>" id="fname_user" name="fname_user" value="<?= strtoupper($this->session->userdata('nama_user')) ?>" readonly>
            </div>

            </div>
            <div class="form-group ">
                <label for="fnote">Catatan</label>
                <textarea name="fnote" class="form-control <?= form_error('fnote') ? 'is-invalid' : '' ?> text-uppercase" id="fnote"><?= $this->input->post('fnote'); ?></textarea>
                <div class="invalid-feedback">
                    <?= form_error('fnote') ?>
                </div>
            </div>
            <button type="submit" class="btn btn-success float-right mt-2">SETUJUI</button>
            <a href="<?= base_url('pembelian') ?>" class="btn btn-primary">TUTUP</a>
        </form>
    <?php }
    function reject_pm($id_pembelian)
    {
        $data = $this->Pembelian_m->get_by_id_pembelian($id_pembelian);
        $item = $this->Item_pembelian_m->get_item_by_no_pembelian($data->no_pembelian);

    ?>
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-success">DATA DOKUMEN</h5>
                <ul class="list-group list-group-flush text-uppercase">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>No. Pembelian</strong>
                        <p class="mb-0">
                            <?= $data->no_pembelian ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Tanggal Pengajuan</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->created_date) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>NIK</strong>
                        <p class="mb-0">
                            <?= $data->nik ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Nama Lengkap</strong>
                        <p class="mb-0">
                            <?= $data->nama_user ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Deadline Pembelian</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->deadline_pembelian) ?>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="text-success">DATA PROJECT</h5>
                <ul class="list-group list-group-flush text-uppercase">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Nama Project</strong>
                        <p class="mb-0">
                            <?= $data->nama_project ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Owner</strong>
                        <p class="mb-0">
                            <?= $data->project_owner ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Deadline</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->project_deadline) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Manager</strong>
                        <p class="mb-0">
                            <?= get_project_manager($data->project_id) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Location</strong>
                        <p class="mb-0">
                            <?= $data->project_location ?>
                        </p>
                    </li>

                </ul>
            </div>

        </div>
        <hr>
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="text-success">DATA BARANG</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NAMA BARANG</th>
                            <th scope="col">SPESIFIKASI</th>
                            <th scope="col">HARGA SATUAN</th>
                            <th scope="col">QTY</th>
                            <th scope="col">SATUAN</th>
                            <th scope="col">TOTAL</th>
                            <th scope="col">NOTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($item as $key) :
                        ?>
                            <tr class="text-uppercase">
                                <th scope="row">
                                    <?= $no++ ?>
                                </th>
                                <td>
                                    <?= $key->nama_barang ?>
                                </td>
                                <td>
                                    <?= $key->spesifikasi ?>
                                </td>
                                <td>
                                    <?= rupiah($key->harga_satuan) ?>
                                </td>
                                <td>
                                    <?= $key->qty ?>
                                </td>
                                <td>
                                    <?= $key->satuan ?>
                                </td>
                                <td>
                                    <?= rupiah($key->total_harga) ?>
                                </td>
                                <td>
                                    <?= $key->note ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot class="bg-secondary">
                        <tr>
                            <th colspan="6" class="text-center">TOTAL PEMBELIAN :</th>
                            <th colspan="2">
                                <?= rupiah(get_total_pembelian_by_no_pembelian($key->no_pembelian)) ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <hr>
        <h4 class="text-danger">REJECT PROJECT MANAGER</h4>
        <form role="form" method="POST" action="<?= base_url('pembelian/process_reject_pm') ?>" autocomplete="off">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
            <input type="hidden" name="fid_kasbon" value="<?= encrypt_url($data->id_pembelian) ?>" style="display: none">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group required">
                        <label class="control-label" for="fno_pembelian">No. Pembelian</label>
                        <input type="text" class="form-control <?= form_error('fno_pembelian') ? 'is-invalid' : '' ?>" id="fno_pembelian" name="fno_pembelian" value="<?= $data->no_pembelian ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required">
                        <label class="control-label" for="ftgl_approve">Tanggal Ditolak</label>
                        <input type="text" class="form-control <?= form_error('ftgl_approve') ? 'is-invalid' : '' ?>" id="ftgl_approve" name="ftgl_approve" value="<?= date('d/m/Y') ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group required">
                <label class="control-label" for="fname_user">Ditolak Oleh</label>
                <input type="text" class="form-control <?= form_error('fname_user') ? 'is-invalid' : '' ?>" id="fname_user" name="fname_user" value="<?= strtoupper($this->session->userdata('nama_user')) ?>" readonly>
            </div>

            </div>
            <div class="form-group ">
                <label for="fnote">Catatan</label>
                <textarea name="fnote" class="form-control <?= form_error('fnote') ? 'is-invalid' : '' ?> text-uppercase" id="fnote"><?= $this->input->post('fnote'); ?></textarea>
                <div class="invalid-feedback">
                    <?= form_error('fnote') ?>
                </div>
            </div>
            <button type="submit" class="btn btn-danger float-right mt-2">TOLAK</button>
            <a href="<?= base_url('pembelian') ?>" class="btn btn-primary">TUTUP</a>
        </form>
    <?php }
    function reject_adm($id_pembelian)
    {
        $data = $this->Pembelian_m->get_by_id_pembelian($id_pembelian);
        $item = $this->Item_pembelian_m->get_item_by_no_pembelian($data->no_pembelian);

    ?>
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-success">DATA DOKUMEN</h5>
                <ul class="list-group list-group-flush text-uppercase">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>No. Pembelian</strong>
                        <p class="mb-0">
                            <?= $data->no_pembelian ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Tanggal Pengajuan</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->created_date) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>NIK</strong>
                        <p class="mb-0">
                            <?= $data->nik ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Nama Lengkap</strong>
                        <p class="mb-0">
                            <?= $data->nama_user ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Deadline Pembelian</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->deadline_pembelian) ?>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="text-success">DATA PROJECT</h5>
                <ul class="list-group list-group-flush text-uppercase">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Nama Project</strong>
                        <p class="mb-0">
                            <?= $data->nama_project ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Owner</strong>
                        <p class="mb-0">
                            <?= $data->project_owner ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Deadline</strong>
                        <p class="mb-0">
                            <?= TanggalIndo($data->project_deadline) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Manager</strong>
                        <p class="mb-0">
                            <?= get_project_manager($data->project_id) ?>
                        </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                        <strong>Project Location</strong>
                        <p class="mb-0">
                            <?= $data->project_location ?>
                        </p>
                    </li>

                </ul>
            </div>

        </div>
        <hr>
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="text-success">DATA BARANG</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NAMA BARANG</th>
                            <th scope="col">SPESIFIKASI</th>
                            <th scope="col">HARGA SATUAN</th>
                            <th scope="col">QTY</th>
                            <th scope="col">SATUAN</th>
                            <th scope="col">TOTAL</th>
                            <th scope="col">NOTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($item as $key) :
                        ?>
                            <tr class="text-uppercase">
                                <th scope="row">
                                    <?= $no++ ?>
                                </th>
                                <td>
                                    <?= $key->nama_barang ?>
                                </td>
                                <td>
                                    <?= $key->spesifikasi ?>
                                </td>
                                <td>
                                    <?= rupiah($key->harga_satuan) ?>
                                </td>
                                <td>
                                    <?= $key->qty ?>
                                </td>
                                <td>
                                    <?= $key->satuan ?>
                                </td>
                                <td>
                                    <?= rupiah($key->total_harga) ?>
                                </td>
                                <td>
                                    <?= $key->note ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot class="bg-secondary">
                        <tr>
                            <th colspan="6" class="text-center">TOTAL PEMBELIAN :</th>
                            <th colspan="2">
                                <?= rupiah(get_total_pembelian_by_no_pembelian($key->no_pembelian)) ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <hr>
        <h4 class="text-danger">REJECT ADMINISTRATOR</h4>
        <form role="form" method="POST" action="<?= base_url('pembelian/process_reject_adm') ?>" autocomplete="off">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
            <input type="hidden" name="fid_kasbon" value="<?= encrypt_url($data->id_pembelian) ?>" style="display: none">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group required">
                        <label class="control-label" for="fno_pembelian">No. Pembelian</label>
                        <input type="text" class="form-control <?= form_error('fno_pembelian') ? 'is-invalid' : '' ?>" id="fno_pembelian" name="fno_pembelian" value="<?= $data->no_pembelian ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required">
                        <label class="control-label" for="ftgl_approve">Tanggal Ditolak</label>
                        <input type="text" class="form-control <?= form_error('ftgl_approve') ? 'is-invalid' : '' ?>" id="ftgl_approve" name="ftgl_approve" value="<?= date('d/m/Y') ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group required">
                <label class="control-label" for="fname_user">Ditolak Oleh</label>
                <input type="text" class="form-control <?= form_error('fname_user') ? 'is-invalid' : '' ?>" id="fname_user" name="fname_user" value="<?= strtoupper($this->session->userdata('nama_user')) ?>" readonly>
            </div>

            </div>
            <div class="form-group ">
                <label for="fnote">Catatan</label>
                <textarea name="fnote" class="form-control <?= form_error('fnote') ? 'is-invalid' : '' ?> text-uppercase" id="fnote"><?= $this->input->post('fnote'); ?></textarea>
                <div class="invalid-feedback">
                    <?= form_error('fnote') ?>
                </div>
            </div>
            <button type="submit" class="btn btn-danger float-right mt-2">TOLAK</button>
            <a href="<?= base_url('pembelian') ?>" class="btn btn-primary">TUTUP</a>
        </form>
<?php }

    function process_approve_pm()
    {
        // HANYA PROJECT MANAGER
        $post = $this->input->post(null, TRUE);
        $this->Status_pembelian_m->add_status_approved_pm_pembelian($post);
        if ($this->db->affected_rows() > 0) {
            // telegram_notif_status_kasbon($post, 'approved', 'Pengajuan Pembelian Telah disetujui');
            $this->session->set_flashdata('success', 'Data pengajuan berhasil disetujui!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    function process_approve_adm()
    {
        // HANYA PROJECT MANAGER
        $post = $this->input->post(null, TRUE);
        $this->Status_pembelian_m->add_status_approved_adm_pembelian($post);
        if ($this->db->affected_rows() > 0) {
            // telegram_notif_status_kasbon($post, 'approved', 'Pengajuan Pembelian Telah disetujui');
            $this->session->set_flashdata('success', 'Data pengajuan berhasil disetujui!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    function process_reject_adm()
    {
        // HANYA PROJECT MANAGER
        $post = $this->input->post(null, TRUE);
        $this->Status_pembelian_m->add_status_rejected_adm_pembelian($post);
        if ($this->db->affected_rows() > 0) {
            // telegram_notif_status_kasbon($post, 'approved', 'Pengajuan Pembelian Telah disetujui');
            $this->session->set_flashdata('success', 'Data pengajuan berhasil ditolak!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    function process_reject_pm()
    {
        // HANYA PROJECT MANAGER
        $post = $this->input->post(null, TRUE);
        $this->Status_pembelian_m->add_status_rejected_pm_pembelian($post);
        if ($this->db->affected_rows() > 0) {
            // telegram_notif_status_kasbon($post, 'approved', 'Pengajuan Pembelian Telah disetujui');
            $this->session->set_flashdata('success', 'Data pengajuan berhasil ditolak!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}

/* End of file Pembelian.php */