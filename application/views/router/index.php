
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Router Mikrotik</h3>
                            <div class="float-right">
                                <a href="<?= base_url('router/add') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Router
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->flashdata('success')) : ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                                    <?= $this->session->flashdata('success') ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($this->session->flashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                    <?= $this->session->flashdata('error') ?>
                                </div>
                            <?php endif; ?>
                            
                            <table id="routerTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Router</th>
                                        <th>IP Address</th>
                                        <th>Username</th>
                                        <th>Port</th>
                                        <th>Status</th>
                                        <th width="25%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($routers)) : ?>
                                        <?php $no = 1; foreach ($routers as $router) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $router->shortname ?></td>
                                                <td><?= $router->nasname ?></td>
                                                <td><?= $router->username ?></td>
                                                <td><?= $router->ports ?></td>
                                                <td>
                                                    <?php if ($router->status == 'connected') : ?>
                                                        <span class="badge badge-success">Connected</span>
                                                    <?php else : ?>
                                                        <span class="badge badge-danger">Disconnected</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('router/check_connection/' . $router->id) ?>" class="btn btn-info btn-sm">
                                                        <i class="fas fa-sync"></i> Cek Koneksi
                                                    </a>
                                                    <a href="<?= base_url('router/download_script/' . $router->id) ?>" class="btn btn-success btn-sm">
                                                        <i class="fas fa-download"></i> Script
                                                    </a>
                                                    <a href="<?= base_url('router/edit/' . $router->id) ?>" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a href="<?= base_url('router/delete/' . $router->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus router ini?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data router</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    $('#routerTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
});
</script>