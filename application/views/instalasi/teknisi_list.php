<section class="content">
    <div class="box">
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Jenis Layanan</th>
                        <th>Bandwidth</th>
                        <th>Alamat Pemasangan</th>
                        <th>Whatsapp</th>
                        <th>Tanggal Penugasan</th>
                        <th>Status instalasi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($assignments as $assignment) : ?>
                        <tr>
                        <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($assignment->nama_lengkap) ?></td>
                            <td><?= htmlspecialchars($assignment->jenis_layanan) ?></td>
                            <td><?= htmlspecialchars($assignment->bandwidth) ?></td>
                            <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;"><?= htmlspecialchars($assignment->alamat_pemasangan) ?></td>
                            <td>
                                <a href="https://wa.me/<?= htmlspecialchars($assignment->whatsapp) ?>" target="_blank">
                                    <?= htmlspecialchars($assignment->whatsapp) ?>
                                </a>
                            </td>
                            <td><?= date('d-m-Y H:i', strtotime($assignment->tanggal_penugasan)) ?></td>
                            <td>
                                <?php if ($assignment->activation_completed > 0) : ?>
                                    <span class="label label-success">Selesai</span>
                                <?php else : ?>
                                    <span class="label label-warning">Belum Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($assignment->activation_completed > 0) : ?>
                                    <a href="<?= site_url('instalasi/edit_instalasi/' . encrypt_url($assignment->id_registrasi_customer)) ?>" class="btn btn-info btn-xs">
                                        <i class="fa fa-edit"></i> Edit Data
                                    </a>
                                <?php else : ?>
                                    <a href="<?= site_url('instalasi/form_instalasi/' . encrypt_url($assignment->id_instalasi_teknisi)) ?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-clipboard-list"></i> Isi instalasi
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('#table1').DataTable();
    });
</script>