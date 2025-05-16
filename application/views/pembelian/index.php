<section class="content-header align-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="mt-2">LIST PEMBELIAN</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-primary mt-2" href="<?= base_url('pembelian/create') ?>">BUAT PEMBELIAN</a>
                </div>
            </div>
        </div>

    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body table-responsive-sm">
                        <table id="tableUSer" class="display nowrap " style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 15px">NO</th>
                                    <th>STATUS</th>
                                    <th>NO PEMBELIAN</th>
                                    <th>TGL PENGAJUAN</th>
                                    <th>PROJECT</th>
                                    <th>TOTAL PEMBELIAN</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pembelian as $key) : ?>
                                    <tr class="text-uppercase">
                                        <td>
                                            <?= $no++ ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-pill <?= cek_status_terakhir_pembelian($key->no_pembelian) == 'approvedadministrator' ? 'badge-success' : '' ?>
                                            <?= cek_status_terakhir_pembelian($key->no_pembelian) == 'approvedprojectmanager' ? 'badge-success' : '' ?>
                                            <?= cek_status_terakhir_pembelian($key->no_pembelian) == 'created' ? 'badge-warning' : '' ?>
                                            <?= cek_status_terakhir_pembelian($key->no_pembelian) == 'rejectedprojectmanager' ? 'badge-danger' : '' ?>
                                            <?= cek_status_terakhir_pembelian($key->no_pembelian) == 'rejectedadministrator' ? 'badge-danger' : '' ?>
                                            <?= cek_status_terakhir_pembelian($key->no_pembelian) == 'closed' ? 'badge-primary' : '' ?>
                                            ">
                                                <?= cek_status_terakhir_pembelian($key->no_pembelian) == 'rejectedprojectmanager' ? 'REJECTED-PM' : '' ?>
                                                <?= cek_status_terakhir_pembelian($key->no_pembelian) == 'rejectedadministrator' ? 'REJECTED-ADM' : '' ?>
                                                <?= cek_status_terakhir_pembelian($key->no_pembelian) == 'approvedadministrator' ? 'APPROVED-ADM' : '' ?>
                                                <?= cek_status_terakhir_pembelian($key->no_pembelian) == 'approvedprojectmanager' ? 'APPROVED-PM' : '' ?>
                                                <?= cek_status_terakhir_pembelian($key->no_pembelian) == 'created' ? 'CREATED' : '' ?>
                                        </td>
                                        <td>
                                            <?= $key->no_pembelian ?>
                                        </td>
                                        <td>
                                            <?= TanggalIndo($key->created_date) ?>
                                        </td>
                                        <td>
                                            <?= $key->nama_project ?>
                                        </td>
                                        <td>
                                            <?= rupiah(get_total_pembelian_by_no_pembelian($key->no_pembelian)) ?>
                                        </td>
                                        <td>
    <?php if ($key->project_manager === $this->session->userdata('id_user')) { ?>
        <a data-toggle="modal" onclick="approveActPm(<?= $key->id_pembelian ?>)" href="#modal_status" class="btn btn-xs <?= cek_status_pembelian($key->no_pembelian, 1) === 1 ? 'btn-secondary disabled' : 'btn-success' ?>">
            <i class="fas fa-check"></i>
        </a>
        <a data-toggle="modal" onclick="rejectActPm(<?= $key->id_pembelian ?>)" href="#modal_status" class="btn btn-xs <?= cek_status_pembelian($key->no_pembelian, 1) === 1 ? 'btn-secondary disabled' : 'btn-danger' ?>">
            <i class="fas fa-times"></i>
        </a>
    <?php } ?>
    <?php if ($this->session->userdata('group') == 1 || $this->session->userdata('group') == 11) { ?>
        <?php if (cek_status_terakhir_pembelian($key->no_pembelian) != 'rejectedprojectmanager') { ?>
            <a data-toggle="modal" onclick="approveActAdm(<?= $key->id_pembelian ?>)" href="#modal_status" class="btn btn-xs <?= cek_status_pembelian($key->no_pembelian, 1) === 0 || cek_status_pembelian($key->no_pembelian, 2) === 1 ? 'btn-secondary disabled' : 'btn-success' ?>">
                <i class="fas fa-check"></i>
            </a>
            <a data-toggle="modal" onclick="rejectActAdm(<?= $key->id_pembelian ?>)" href="#modal_status" class="btn btn-xs <?= cek_status_pembelian($key->no_pembelian, 1) === 0 || cek_status_pembelian($key->no_pembelian, 2) === 1 ? 'btn-secondary disabled' : 'btn-danger' ?>">
                <i class="fas fa-times"></i>
            </a>
        <?php } ?>
    <?php } ?>
    <a data-toggle="modal" onclick="getDetail(<?= $key->id_pembelian ?>)" href="#modal_Detail" class="btn btn-primary btn-xs">
        <i class="fas fa-eye"></i>
    </a>
    <a href="https://wa.me/6285295644177/?text=PEMBERITAHUAN%20GAS%0A%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%0APengajuan%20%3A%20PEMBELIAN%0ANo.%20Dokumen%20%3A%20<?= $key->no_pembelian ?>%0ADibuat%20Oleh%20%3A%20<?= strtoupper($key->nama_user) ?>%0ADeadline%20Pembelian%20%3A%20<?= $key->deadline_pembelian ?>%0A%0AKlik%20link%20dibawah%20ini%20untuk%20melihat%20detail%20%3A%0A<?= base_url('pembelian') ?>" class="btn btn-xs btn-success" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
    
    <a data-toggle="modal" onclick="deleteConfirm('<?= site_url('pembelian/delete/'.$key->id_pembelian) ?>')" href="#modal_Delete" class="btn btn-danger btn-xs">
        <i class="fas fa-trash"></i>
    </a>
</td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Delete Confirmation-->
<div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-3 d-flex justify-content-center">
                        <i class="fa  fa-exclamation-triangle" style="font-size: 70px; color:red;"></i>
                    </div>
                    <div class="col-9 pt-2">
                        <h5>Apakah anda yakin?</h5>
                        <span>Data yang dihapus tidak akan bisa dikembalikan.</span>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"> Batal</button>
                <a id="btn-delete" class="btn btn-danger" href="#"> Hapus</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_Detail">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body" id="bodymodal_Detail">
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_status">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body" id="bodymodal_status">
            </div>
        </div>
    </div>
</div>
<!-- Delete Confirm -->
<script type="text/javascript">
    function deleteConfirm(url) {
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }

    function approveActPm(id) {
        $.ajax({
            type: "get",
            url: "<?= site_url('pembelian/approve_pm/'); ?>" + id,
            // data: "id=" + id,
            dataType: "html",
            success: function(response) {
                $('#bodymodal_status').empty();
                $('#bodymodal_status').append(response);
            }
        });
    }

    function approveActAdm(id) {
        $.ajax({
            type: "get",
            url: "<?= site_url('pembelian/approve_adm/'); ?>" + id,
            // data: "id=" + id,
            dataType: "html",
            success: function(response) {
                $('#bodymodal_status').empty();
                $('#bodymodal_status').append(response);
            }
        });
    }

    function rejectActAdm(id) {
        $.ajax({
            type: "get",
            url: "<?= site_url('pembelian/reject_adm/'); ?>" + id,
            // data: "id=" + id,
            dataType: "html",
            success: function(response) {
                $('#bodymodal_status').empty();
                $('#bodymodal_status').append(response);
            }
        });
    }

    function rejectActPm(id) {
        $.ajax({
            type: "get",
            url: "<?= site_url('pembelian/reject_pm/'); ?>" + id,
            // data: "id=" + id,
            dataType: "html",
            success: function(response) {
                $('#bodymodal_status').empty();
                $('#bodymodal_status').append(response);
            }
        });
    }

    function getDetail(id) {
        $.ajax({
            type: "get",
            url: "<?= site_url('pembelian/detail/'); ?>" + id,
            dataType: "html",
            success: function(response) {
                $('#bodymodal_Detail').empty();
                $('#bodymodal_Detail').append(response);
            }
        });
    }
</script>