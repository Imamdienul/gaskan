
    <section class="content">
        <div class="container-fluid">
            <!-- Flashdata -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Optical Distribution Point (ODP)</h3>
                            <div class="card-tools">
                                <a href="<?= base_url('odp/add') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah ODP Baru
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="odp-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama ODP</th>
                                        <th>Kapasitas</th>
                                        <th>Terpakai</th>
                                        <th>Wilayah</th>
                                        <th>Alamat</th>
                                        <th width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($odps as $odp): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $odp->nama_odp ?></td>
                                        <td><?= $odp->kapasitas ?></td>
                                        <td>
                                            <span class="badge <?= ($odp->terpakai >= $odp->kapasitas) ? 'badge-danger' : (($odp->terpakai/$odp->kapasitas >= 0.8) ? 'badge-warning' : 'badge-success') ?>">
                                                <?= $odp->terpakai ?> / <?= $odp->kapasitas ?>
                                            </span>
                                        </td>
                                        <td><?= $odp->id_wilayah ?></td>
                                        <td><?= $odp->alamat ?></td>
                                        <td>
                                            <a href="<?= base_url('odp/detail/'.$odp->id_odp) ?>" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a href="<?= base_url('odp/edit/'.$odp->id_odp) ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="#" data-href="<?= base_url('odp/delete/'.$odp->id_odp) ?>" onclick="confirmDelete(this)" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
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
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirm-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Hapus</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ODP ini?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <a id="btn-delete" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
    $("#odp-table").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#odp-table_wrapper .col-md-6:eq(0)');
});

function confirmDelete(el) {
    var url = $(el).data('href');
    $("#btn-delete").attr("href", url);
    $("#confirm-delete").modal('show');
}
</script>