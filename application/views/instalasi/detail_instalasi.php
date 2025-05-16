<!-- application/views/instalasi/detail_instalasi.php -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail instalasi</h3>
                <div class="card-tools">
                    <a href="<?= site_url('instalasi/generate_pdf') ?>" class="btn btn-info" target="_blank">
                        <i class="fas fa-checked"></i> Export PDF
                    </a>
                    <a href="<?= site_url('instalasi/teknisi_list') ?>" class="btn btn-secondary">
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

                    <!-- Instalasi Information -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h3 class="card-title">Informasi instalasi</h3>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>Teknisi</th>
                                        <td>: <?= $Instalasi->nama_teknisi ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Paket</th>
                                        <td>: <?= $Instalasi->nama_paket ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Pemasangan</th>
                                        <td>: <?= $Instalasi->tgl_pasang ?? '-' ?> <?= $Instalasi->waktu_pasang ?? '00:00' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Area</th>
                                        <td>: <?= $Instalasi->nama_wilayah ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Paket</th>
                                        <td>: <?= $Instalasi->nama_paket ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>ODP</th>
                                        <td>: <?= $Instalasi->id_odp ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Port ODP</th>
                                        <td>: <?= $Instalasi->port_odp ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Panjang Kabel</th>
                                        <td>: <?= $Instalasi->panjang_kabel . ' meter' ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Roll Kabel</th>
                                        <td>: <?= $Instalasi->nomor_roll_kabel ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Merk Modem/Router/ONT</th>
                                        <td>: <?= $Instalasi->merk_modem ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tipe Modem/Router/ONT</th>
                                        <td>: <?= $Instalasi->tipe_modem ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>SN Modem/Router/ONT</th>
                                        <td>: <?= $Instalasi->sn_modem ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mac Address Modem/Router/ONT</th>
                                        <td>: <?= $Instalasi->mac_address ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Redaman Pelanggan</th>
                                        <td>: <?= $Instalasi->redaman_odp ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status instalasi</th>
                                        <td>: <span class="badge badge-<?= $Instalasi->status_instalasi == 'completed' ? 'success' : 'warning' ?>">
                                            <?= $Instalasi->status_instalasi ?>
                                        </span></td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Oleh</th>
                                        <td>: <?= $Instalasi->nama_teknisi ?></td>
                                    </tr>
                                    <?php if ($Instalasi->updated_by) : ?>
                                    <tr>
                                        <th>Diperbarui Oleh</th>
                                        <td>: <?= $Instalasi->updated_by_name ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Diperbarui</th>
                                        <td>: <?= date('d-m-Y H:i', strtotime($Instalasi->updated_date)) ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </table>

                                <!-- Edit Button -->
                                <div class="mt-3">
                                    <a href="<?= site_url('instalasi/edit_instalasi/' . encrypt_url($customer->id_registrasi_customer)) ?>" class="btn btn-warning btn-block">
                                        <i class="fas fa-edit"></i> Edit Data instalasi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instalasi Photos -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h3 class="card-title">Foto Instalasi</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- ODP Connectiom Photo -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Foto Koneksi ODP</h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <?php if (!empty($Instalasi->foto_koneksi_odp)) : ?>
                                                    <a href="<?= base_url('uploads/instalasi/' . $Instalasi->foto_koneksi_odp) ?>" target="_blank">
                                                        <img src="<?= base_url('uploads/instalasi/' . $Instalasi->foto_koneksi_odp) ?>" alt="Foto Koneksi ODP" class="img-fluid" style="max-height: 200px;">
                                                    </a>
                                                    <?php if (!empty($Instalasi->deskripsi_foto_koneksi_odp)) : ?>
                                                        <div class="mt-2">
                                                            <strong>Keterangan:</strong>
                                                            <p><?= $Instalasi->deskripsi_foto_koneksi_odp ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <p class="text-center text-muted">Tidak ada foto</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Redaman Pelanggan Photo -->
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Foto Redaman Pelanggan</h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <?php if (!empty($Instalasi->foto_redaman_pelanggan)) : ?>
                                                    <a href="<?= base_url('uploads/instalasi/' . $Instalasi->foto_redaman_pelanggan) ?>" target="_blank">
                                                        <img src="<?= base_url('uploads/instalasi/' . $Instalasi->foto_redaman_pelanggan) ?>" alt="Foto ODP" class="img-fluid" style="max-height: 200px;">
                                                    </a>
                                                    <?php if (!empty($Instalasi->deskripsi_foto_redaman_pelanggan)) : ?>
                                                        <div class="mt-2">
                                                            <strong>Keterangan:</strong>
                                                            <p><?= $Instalasi->deskripsi_foto_redaman_pelanggan ?></p>
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
                                                <h3 class="card-title">Foto Instalasi</h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <?php if (!empty($Instalasi->foto_instalasi)) : ?>
                                                    <a href="<?= base_url('uploads/instalasi/' . $Instalasi->foto_instalasi) ?>" target="_blank">
                                                        <img src="<?= base_url('uploads/instalasi/' . $Instalasi->foto_instalasi) ?>" alt="Foto Tambahan" class="img-fluid" style="max-height: 200px;">
                                                    </a>
                                                    <?php if (!empty($Instalasi->deskripsi_foto_instalasi)) : ?>
                                                        <div class="mt-2">
                                                            <strong>Keterangan:</strong>
                                                            <p><?= $Instalasi->deskripsi_foto_instalasi ?></p>
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
                                                <h3 class="card-title">Foto Rumah</h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <?php if (!empty($Instalasi->foto_rumah)) : ?>
                                                    <a href="<?= base_url('uploads/instalasi/' . $Instalasi->foto_rumah) ?>" target="_blank">
                                                        <img src="<?= base_url('uploads/instalasi/' . $Instalasi->foto_rumah) ?>" alt="Foto ODP Tersisa" class="img-fluid" style="max-height: 200px;">
                                                    </a>
                                                    <?php if (!empty($Instalasi->deskripsi_foto_rumah)) : ?>
                                                        <div class="mt-2">
                                                            <strong>Keterangan:</strong>
                                                            <p><?= $Instalasi->deskripsi_foto_rumah ?></p>
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

                <!-- Instalasi Notes -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-warning">
                                <h3 class="card-title">Catatan Instalasi</h3>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($Instalasi->catatan)) : ?>
                                    <p><?= nl2br($Instalasi->catatan) ?></p>
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