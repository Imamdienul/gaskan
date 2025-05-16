
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Hasil Survey Pelanggan</h3>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-check"></i> <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-ban"></i> <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>

                <table id="surveyTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Pelanggan</th>
                            <th>No Registrasi</th>
                            <th>Identitas Registrasi</th>
                            <th>Jenis Registrasi</th>
                            <th>Alamat Pemasangan</th>
                            <th>Whatsapp</th>
                            <th>Layanan</th>
                            <th>Jenis Survey</th>
                            <th>ODP</th>
                            <th>Jarak</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
foreach ($customers as $customer) { ?>
    <tr>
        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= $no++; ?></td>
        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= $customer->nama_lengkap; ?></td>
        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= $customer->nomor_registrasi; ?></td>
        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= $customer->jenis_identitas; ?></td>
        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= $customer->jenis_formulir; ?></td>
        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= $customer->alamat_pemasangan; ?></td>
        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= $customer->whatsapp; ?></td>
        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= $customer->jenis_layanan; ?> <?= $customer->bandwidth; ?> Mbps</td>
        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= $customer->jenis_survey ?? '-'; ?></td>
        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= $customer->nama_odp ?? '-'; ?></td>
        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= $customer->jarak_rumah_odp ? $customer->jarak_rumah_odp . ' meter' : '-'; ?></td>
        <td>
            <a href="<?= site_url('survey/detail_survey/' . encrypt_url($customer->id_registrasi_customer)); ?>" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> Detail
            </a>

        </td>
    </tr>
<?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#surveyTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#surveyTable_wrapper .col-md-6:eq(0)');
    });
</script>