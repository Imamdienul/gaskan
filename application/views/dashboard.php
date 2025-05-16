<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Gisaka Automation System</h1> Dashboard

            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php if ($isdefault) { ?>
            <div class="alert alert-dismissible alert-default-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-exclamation-triangle"></i>Demi keamanan akun anda, silahkan mengganti password pada
                menu <a href="<?= base_url('pengaturan/ganti_pass') ?>" class="text-info">pengaturan/ganti_password</a>
            </div>
        <?php } ?>
       
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-mobile-alt mr-2"></i>Download Aplikasi Mobile
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="<?= base_url('uploads/app-release.apk') ?>" class="btn btn-success btn-lg btn-block">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fab fa-android fa-2x mr-3"></i>
                                <div class="text-left">
                                    <span class="d-block">Download for</span>
                                    <strong>Android</strong>
                                </div>
                            </div>
                        </a>
                        <p class="text-muted mt-2 text-center">
                            <small>Versi 1.0.0 | Ukuran: 15 MB</small>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="https://apps.apple.com/your-app-store-link" class="btn btn-primary btn-lg btn-block">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fab fa-apple fa-2x mr-3"></i>
                                <div class="text-left">
                                    <span class="d-block">Download on</span>
                                    <strong>Apple</strong>
                                </div>
                            </div>
                        </a>
                        <p class="text-muted mt-2 text-center">
                            <small>Versi 1.0.0 | Ukuran: 14 MB</small>
                        </p>
                    </div>
                </div>
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-info-circle mr-2"></i>
                    Pastikan Anda mengizinkan instalasi dari sumber tidak dikenal di pengaturan perangkat Anda
                </div>
            </div>
        </div>
    </div>
</div>
        <?php if ($pembelian) { ?>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                JOB LIST - PENGAJUAN PEMBELIAN
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="tableUSer" class="display nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 15px">NO</th>
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
                                                                SETUJUI
                                                            </a>
                                                            <a data-toggle="modal" onclick="rejectActPm(<?= $key->id_pembelian ?>)" href="#modal_status" class="btn btn-xs <?= cek_status_pembelian($key->no_pembelian, 1) === 1 ? 'btn-secondary disabled' : 'btn-danger' ?>">
                                                                TOLAK
                                                            </a>
                                                        <?php } ?>
                                                        <?php if ($this->session->userdata('group') == 1) { ?>
                                                            <a data-toggle="modal" onclick="approveActAdm(<?= $key->id_pembelian ?>)" href="#modal_status" class="btn btn-xs <?= cek_status_pembelian($key->no_pembelian, 1) === 0 || cek_status_pembelian($key->no_pembelian, 2) === 1 ? 'btn-secondary disabled' : 'btn-success' ?>">
                                                                SETUJUI
                                                            </a>
                                                            <a data-toggle="modal" onclick="rejectActAdm(<?= $key->id_pembelian ?>)" href="#modal_status" class="btn btn-xs <?= cek_status_pembelian($key->no_pembelian, 1) === 0 || cek_status_pembelian($key->no_pembelian, 2) === 1 ? 'btn-secondary disabled' : 'btn-danger' ?>">
                                                                TOLAK
                                                            </a>
                                                        <?php } ?>
                                                        <a data-toggle="modal" onclick="getDetail(<?= $key->id_pembelian ?>)" href="#modal_Detail" class="btn btn-primary btn-xs">
                                                            LIHAT DETAIL</a>
                                                        <a href="https://wa.me/6285295644177/?text=PEMBERITAHUAN%20GAS%0A%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%0APengajuan%20%3A%20PEMBELIAN%0ANo.%20Dokumen%20%3A%20<?= $key->no_pembelian ?>%0ADibuat%20Oleh%20%3A%20<?= strtoupper($key->nama_user) ?>%0ADeadline%20Pembelian%20%3A%20<?= $key->deadline_pembelian ?>%0A%0AKlik%20link%20dibawah%20ini%20untuk%20melihat%20detail%20%3A%0A<?= base_url('pembelian') ?>" class="btn btn-xs btn-success" target="_blank"><i class="fab fa-whatsapp"></i> KIRIM WA</a>
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
            </div>
        <?php } ?>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="modal_Detail">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body" id="bodymodal_Detail">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_status">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="bodymodal_status">
            </div>
        </div>
    </div>
</div>

<script>
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