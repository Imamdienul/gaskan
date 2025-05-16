<!-- application/views/survey/detail_survey.php -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Hasil Survey</h3>
                <div class="card-tools">
                    <a href="<?= site_url('survey') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
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

                <div class="row">
                    <!-- Customer Information -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title">Informasi Pelanggan</h3>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>: <?= $customer->nama_lengkap ?></td>
                                    </tr>
                                    <tr>
                                        <th>No Registrasi</th>
                                        <td>: <?= $customer->nomor_registrasi ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>: <?= $customer->email ?></td>
                                    </tr>
                                    <tr>
                                        <th>WhatsApp</th>
                                        <td>: <?= $customer->whatsapp ?></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Pemasangan</th>
                                        <td>: <?= $customer->alamat_pemasangan ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Layanan</th>
                                        <td>: <?= $customer->jenis_layanan ?> <?= $customer->bandwidth ?> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Survey Information -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h3 class="card-title">Informasi Survey</h3>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>Teknisi</th>
                                        <td>: <?= $survey->nama_teknisi ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Survey</th>
                                        <td>: <?= $survey->jenis_survey ?></td>
                                    </tr>
                                    <tr>
                                        <th>ODP</th>
                                        <td>: <?= $survey->nama_odp ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jarak Rumah ke ODP</th>
                                        <td>: <?= $survey->jarak_rumah_odp ? $survey->jarak_rumah_odp . ' meter' : '-' ?></td>
                                    </tr>
                                    <?php if ($survey->status_survey == 'final') : ?>
                                    <tr>
                                        <th>Panjang Kabel</th>
                                        <td>: <?= $survey->panjang_kabel ? $survey->panjang_kabel . ' meter' : '-' ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
    <th>Status Survey</th>
    <td>: <span class="badge badge-<?= $survey->status_survey == 'final' ? 'success' : 'warning' ?>">
        <?= $survey->status_survey ?>
    </span></td>
</tr>

                                    <tr>
                                        <th>Tanggal Survey</th>
                                        <td>: <?= date('d-m-Y H:i', strtotime($survey->tanggal_survey)) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Oleh</th>
                                        <td>: <?= $survey->nama_teknisi ?></td>
                                    </tr>
                                    <?php if ($survey->updated_by) : ?>
                                    <tr>
                                        <th>Diperbarui Oleh</th>
                                        <td>: <?= $survey->updated_by_name ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Diperbarui</th>
                                        <td>: <?= date('d-m-Y H:i', strtotime($survey->updated_at)) ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </table>

                                <!-- Edit Button -->
                                <div class="mt-3">
                                    <a href="<?= site_url('survey/edit_survey/' . encrypt_url($customer->id_registrasi_customer)) ?>" class="btn btn-warning btn-block">
                                        <i class="fas fa-edit"></i> Edit Data Survey
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Survey Photos -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h3 class="card-title">Foto Survey</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- House Photo -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Foto 1</h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <?php if (!empty($survey->foto_rumah)) : ?>
                                                    <a href="<?= base_url('uploads/survey/' . $survey->foto_rumah) ?>" target="_blank">
                                                        <img src="<?= base_url('uploads/survey/' . $survey->foto_rumah) ?>" alt="Foto Rumah" class="img-fluid" style="max-height: 200px;">
                                                    </a>
                                                    <?php if (!empty($survey->deskripsi_foto_rumah)) : ?>
                                                        <div class="mt-2">
                                                            <strong>Keterangan:</strong>
                                                            <p><?= $survey->deskripsi_foto_rumah ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <p class="text-center text-muted">Tidak ada foto</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ODP Photo -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Foto ODP</h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <?php if (!empty($survey->foto_odp)) : ?>
                                                    <a href="<?= base_url('uploads/survey/' . $survey->foto_odp) ?>" target="_blank">
                                                        <img src="<?= base_url('uploads/survey/' . $survey->foto_odp) ?>" alt="Foto ODP" class="img-fluid" style="max-height: 200px;">
                                                    </a>
                                                    <?php if (!empty($survey->deskripsi_foto_odp)) : ?>
                                                        <div class="mt-2">
                                                            <strong>Keterangan:</strong>
                                                            <p><?= $survey->deskripsi_foto_odp ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <p class="text-center text-muted">Tidak ada foto</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Remaining ODP Photo -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Foto ODP Tersisa</h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <?php if (!empty($survey->foto_odp_tersisa)) : ?>
                                                    <a href="<?= base_url('uploads/survey/' . $survey->foto_odp_tersisa) ?>" target="_blank">
                                                        <img src="<?= base_url('uploads/survey/' . $survey->foto_odp_tersisa) ?>" alt="Foto ODP Tersisa" class="img-fluid" style="max-height: 200px;">
                                                    </a>
                                                    <?php if (!empty($survey->deskripsi_foto_odp_tersisa)) : ?>
                                                        <div class="mt-2">
                                                            <strong>Keterangan:</strong>
                                                            <p><?= $survey->deskripsi_foto_odp_tersisa ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <p class="text-center text-muted">Tidak ada foto</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Additional Photo -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Foto Tambahan</h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <?php if (!empty($survey->foto_tambahan)) : ?>
                                                    <a href="<?= base_url('uploads/survey/' . $survey->foto_tambahan) ?>" target="_blank">
                                                        <img src="<?= base_url('uploads/survey/' . $survey->foto_tambahan) ?>" alt="Foto Tambahan" class="img-fluid" style="max-height: 200px;">
                                                    </a>
                                                    <?php if (!empty($survey->deskripsi_foto_tambahan)) : ?>
                                                        <div class="mt-2">
                                                            <strong>Keterangan:</strong>
                                                            <p><?= $survey->deskripsi_foto_tambahan ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <p class="text-center text-muted">Tidak ada foto</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Survey Notes -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-warning">
                                <h3 class="card-title">Catatan Survey</h3>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($survey->catatan)) : ?>
                                    <p><?= nl2br($survey->catatan) ?></p>
                                <?php else : ?>
                                    <p class="text-center text-muted">Tidak ada catatan</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>