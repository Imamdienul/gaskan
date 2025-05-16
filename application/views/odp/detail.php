
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detail Optical Distribution Point (ODP)</h3>
                            <div class="card-tools">
                                <a href="<?= base_url('odp/edit/'.$odp->id_odp) ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="#" data-href="<?= base_url('odp/delete/'.$odp->id_odp) ?>" onclick="confirmDelete(this)" class="btn btn-danger ml-2">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 30%">ID ODP</th>
                                                <td><?= $odp->id_odp ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nama ODP</th>
                                                <td><?= $odp->nama_odp ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kapasitas</th>
                                                <td><?= $odp->kapasitas ?></td>
                                            </tr>
                                            <tr>
                                                <th>Terpakai</th>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar <?= ($odp->terpakai >= $odp->kapasitas) ? 'bg-danger' : (($odp->terpakai/$odp->kapasitas >= 0.8) ? 'bg-warning' : 'bg-success') ?>" role="progressbar" 
                                                            style="width: <?= min(($odp->terpakai/$odp->kapasitas*100), 100) ?>%" 
                                                            aria-valuenow="<?= $odp->terpakai ?>" aria-valuemin="0" aria-valuemax="<?= $odp->kapasitas ?>">
                                                            <?= $odp->terpakai ?> / <?= $odp->kapasitas ?> (<?= number_format(($odp->terpakai/$odp->kapasitas*100), 1) ?>%)
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Wilayah</th>
                                                <td><?= $odp->id_wilayah ?></td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td><?= $odp->alamat ?: '<span class="text-muted">Tidak ada</span>' ?></td>
                                            </tr>
                                            <tr>
                                                <th>Koordinat</th>
                                                <td>
                                                    <?php if ($odp->latitude && $odp->longitude): ?>
                                                        Lat: <?= $odp->latitude ?>, Long: <?= $odp->longitude ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">Tidak ada</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Dibuat Oleh</th>
                                                <td>ID User: <?= $odp->created_by ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Dibuat</th>
                                                <td><?= date('d F Y H:i', strtotime($odp->created_date)) ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <?php if ($odp->latitude && $odp->longitude): ?>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Lokasi ODP</h3>
                                            </div>
                                            <div class="card-body">
                                                <div id="map" style="height: 400px;"></div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="callout callout-info">
                                            <h5>Lokasi tidak tersedia</h5>
                                            <p>Data koordinat ODP belum ditambahkan. Silahkan edit data untuk menambahkan lokasi.</p>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Info card -->
                                    <div class="card <?= ($odp->terpakai >= $odp->kapasitas) ? 'card-danger' : (($odp->terpakai/$odp->kapasitas >= 0.8) ? 'card-warning' : 'card-success') ?>">
                                        <div class="card-header">
                                            <h3 class="card-title">Status Kapasitas</h3>
                                        </div>
                                        <div class="card-body">
                                            <?php if ($odp->terpakai >= $odp->kapasitas): ?>
                                                <p><i class="fas fa-exclamation-triangle"></i> <strong>Overload!</strong> ODP sudah melebihi kapasitas.</p>
                                            <?php elseif ($odp->terpakai/$odp->kapasitas >= 0.8): ?>
                                                <p><i class="fas fa-exclamation-circle"></i> <strong>Perhatian!</strong> Kapasitas hampir penuh.</p>
                                            <?php else: ?>
                                                <p><i class="fas fa-check-circle"></i> <strong>Baik!</strong> Kapasitas masih mencukupi.</p>
                                            <?php endif; ?>
                                            <p>Tersedia: <strong><?= max(0, $odp->kapasitas - $odp->terpakai) ?></strong> dari total <?= $odp->kapasitas ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?= base_url('odp') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <a href="<?= base_url('odp/edit/'.$odp->id_odp) ?>" class="btn btn-warning float-right ml-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="#" data-href="<?= base_url('odp/delete/'.$odp->id_odp) ?>" onclick="confirmDelete(this)" class="btn btn-danger float-right">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                        <?php if ($odp->latitude && $odp->longitude): ?>
<script>
$(function() {
    // Inisialisasi map
    var map = L.map('map').setView([<?= $odp->latitude ?>, <?= $odp->longitude ?>], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Tambahkan marker
    L.marker([<?= $odp->latitude ?>, <?= $odp->longitude ?>])
        .addTo(map)
        .bindPopup("<?= htmlspecialchars($odp->nama_odp) ?>");
});
</script>
<?php endif; ?>