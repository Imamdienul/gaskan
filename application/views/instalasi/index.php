<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Pelanggan untuk instalasi</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr class="bg-primary">
                        <th width="5%">#</th>
                        <th>Nomor Registrasi</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Layanan</th>
                        <th>Bandwith</th>
                        <th>Alamat Pemasangan</th>
                        <th>Whatsapp</th>
                        <th width="15%">Status Survey</th>
                        <th width="15%">Status instalasi</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($customers as $customer) : 
                        // Get assignment info
                        $assignment = $this->Instalasi_m->get_activation_assignment($customer->id_registrasi_customer);
                        $status_badge = '';
                        $status_instalasi_badge = '';
                        
                        if ($customer->status_survey == 'belum') {
                            $status_badge = '<span class="badge badge-secondary">Belum Ditugaskan</span>';
                        } else if ($customer->status_survey == 'proses') {
                            $status_badge = '<span class="badge badge-warning">Sedang Diproses</span>';
                        } else if ($customer->status_survey == 'selesai') {
                            $status_badge = '<span class="badge badge-success">Selesai Survey</span>';
                        }
                        
                        if ($customer->status_instalasi == 'belum') {
                            $status_instalasi_badge = '<span class="badge badge-secondary">Belum Ditugaskan</span>';
                        } else if ($customer->status_instalasi == 'proses') {
                            $status_instalasi_badge = '<span class="badge badge-warning">Sedang Diproses</span>';
                        } else if ($customer->status_instalasi == 'selesai') {
                            $status_instalasi_badge = '<span class="badge badge-success">Selesai instalasi</span>';
                        }
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($customer->nomor_registrasi) ?></td>
                            <td><?= htmlspecialchars($customer->nama_lengkap) ?></td>
                            <td><?= htmlspecialchars($customer->jenis_layanan) ?></td>
                            <td><?= htmlspecialchars($customer->bandwidth) ?></td>
                            <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;">
                                <?= htmlspecialchars($customer->alamat_pemasangan) ?>, <?= htmlspecialchars($customer->desa) ?>, <?= htmlspecialchars($customer->kecamatan) ?>
                            </td>
                            <td>
                                <a href="https://wa.me/<?= preg_replace('/^0/', '62', $customer->whatsapp) ?>" target="_blank" class="btn btn-xs btn-success">
                                    <i class="fab fa-whatsapp"></i> <?= htmlspecialchars($customer->whatsapp) ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <?= $status_badge ?>
                            </td>
                            <td class="text-center">
                                <?= $status_instalasi_badge ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#statusModal<?= $customer->id_registrasi_customer ?>">
                                        <i class="fas fa-eye"></i> Status
                                    </button>
                                    <?php if ($customer->status_survey == 'selesai' && $customer->status_instalasi != 'selesai') : ?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assignModal<?= $customer->id_registrasi_customer ?>">
                                            <i class="fas fa-user-plus"></i> Assign
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modals should be placed outside the table for better DOM structure -->
<?php foreach ($customers as $customer) : 
    $assignment = $this->Instalasi_m->get_activation_assignment($customer->id_registrasi_customer);
    $status_badge = '';
    $status_instalasi_badge = '';
    
    if ($customer->status_survey == 'belum') {
        $status_badge = '<span class="badge badge-secondary">Belum Ditugaskan</span>';
    } else if ($customer->status_survey == 'proses') {
        $status_badge = '<span class="badge badge-warning">Sedang Diproses</span>';
    } else if ($customer->status_survey == 'selesai') {
        $status_badge = '<span class="badge badge-success">Selesai Survey</span>';
    }
                        
    if ($customer->status_instalasi == 'belum') {
        $status_instalasi_badge = '<span class="badge badge-secondary">Belum Ditugaskan</span>';
    } else if ($customer->status_instalasi == 'proses') {
        $status_instalasi_badge = '<span class="badge badge-warning">Sedang Diproses</span>';
    } else if ($customer->status_instalasi == 'selesai') {
        $status_instalasi_badge = '<span class="badge badge-success">Selesai instalasi</span>';
    }
?>
<!-- Status Modal -->
<div class="modal fade" id="statusModal<?= $customer->id_registrasi_customer ?>" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="statusModalLabel"><i class="fas fa-info-circle"></i> Status Survey Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Pelanggan</th>
                        <td><?= htmlspecialchars($customer->nama_lengkap) ?></td>
                    </tr>
                    <tr>
                        <th>Status Survey</th>
                        <td><?= $status_badge ?></td>
                    </tr>
                    <tr>
                        <th>Status instalasi</th>
                        <td><?= $status_instalasi_badge ?></td>
                    </tr>
                    <?php if (!empty($assignment)) : ?>
                        <tr>
                            <th>Ditugaskan Kepada</th>
                            <td><strong><?= htmlspecialchars($assignment->nama_teknisi) ?></strong> (<?= htmlspecialchars($assignment->phone_user) ?>)</td>
                        </tr>
                        <tr>
                            <th>Tanggal Penugasan instalasi</th>
                            <td><?= date('d M Y H:i', strtotime($assignment->created_date)) ?></td>
                        </tr>
                        <tr>
                            <th>Progress</th>
                            <td>
                                <?php if ($assignment->activation_completed > 0) : ?>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                    </div>
                                    <span class="badge badge-success">Selesai</span>
                                <?php else : ?>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                                    </div>
                                    <span class="badge badge-warning">Sedang Dikerjakan</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Catatan Penugasan instalasi</th>
                            <td><?= htmlspecialchars($assignment->catatan) ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                <i class="fas fa-info-circle"></i> Belum ada teknisi yang ditugaskan
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Assign Modal -->
<div class="modal fade" id="assignModal<?= $customer->id_registrasi_customer ?>" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url('instalasi/assign_activation') ?>" method="post">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="assignModalLabel"><i class="fas fa-user-plus"></i> <?= empty($assignment) ? 'Assign Teknisi untuk instalasi' : 'Edit Penugasan Teknisi instalasi' ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pelanggan</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($customer->nama_lengkap) ?>" readonly>
                        <input type="hidden" name="id_registrasi_customer" value="<?= $customer->id_registrasi_customer ?>">
                        <?php if (!empty($assignment)) : ?>
                            <input type="hidden" name="id_instalasi_teknisi" value="<?= $assignment->id_instalasi_teknisi ?>">
                            <input type="hidden" name="id_teknisi" value="<?= $assignment->id_teknisi ?>">
                            <input type="hidden" name="is_update" value="1">
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" readonly><?= htmlspecialchars($customer->alamat_pemasangan) ?>, <?= htmlspecialchars($customer->desa) ?>, <?= htmlspecialchars($customer->kecamatan) ?></textarea>
                    </div>
                    <?php if (!empty($assignment)) : ?>
                        <div class="form-group">
                            <label>Teknisi Saat Ini</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($assignment->nama_teknisi) ?> (<?= htmlspecialchars($assignment->phone_user) ?>)" readonly>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label><?= empty($assignment) ? 'Pilih Teknisi' : 'Ganti Teknisi' ?> <span class="text-danger">*</span></label>
                        <select name="id_teknisi" class="form-control select2" style="width: 100%;" required>
                            <option value="">- Pilih Teknisi -</option>
                            <?php foreach ($teknisi as $t) : ?>
                                <option value="<?= $t->id_user ?>" <?= (!empty($assignment) && $assignment->id_teknisi == $t->id_user) ? 'selected' : '' ?>><?= htmlspecialchars($t->nama_user) ?> (<?= htmlspecialchars($t->phone_user) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan untuk Teknisi</label>
                        <textarea name="catatan" class="form-control" placeholder="Berikan catatan khusus untuk teknisi jika diperlukan..."><?= !empty($assignment) ? htmlspecialchars($assignment->catatan) : '' ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-<?= empty($assignment) ? 'save' : 'sync-alt' ?>"></i> 
                        <?= empty($assignment) ? 'Assign Teknisi' : 'Update Penugasan' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#table1').DataTable({
            "responsive": true,
            "processing": true,
            "language": {
                "processing": '<i class="fas fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
            },
            "columnDefs": [
                { "orderable": false, "targets": [7, 8] }
            ],
            "order": [[0, 'asc']]
        });
        
        // Initialize Select2
    });
</script>