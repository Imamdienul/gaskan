<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Pelanggan dari Registrasi</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pilih Data Registrasi</h3>
                        <div class="float-right">
                            <a href="<?= base_url('customer/create') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Manual
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="registrasi_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No. Registrasi</th>
                                    <th>Nama Lengkap</th>
                                    <th>No. Identitas</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($registrasi_list as $reg) : ?>
                                <tr>
                                    <td><?= $reg->nomor_registrasi ?></td>
                                    <td><?= $reg->nama_lengkap ?></td>
                                    <td><?= $reg->nomor_identitas ?></td>
                                    <td><?= $reg->seluler ?></td>
                                    <td><?= $reg->alamat_identitas ?></td>
                                    <td>
                                        <form action="<?= base_url('customer/process_create_from_registrasi') ?>" method="POST">
                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                                                value="<?= $this->security->get_csrf_hash(); ?>">
                                            <input type="hidden" name="id_registrasi" value="<?= $reg->id_registrasi_customer ?>">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-plus"></i> Jadikan Pelanggan
                                            </button>
                                        </form>
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

<script>
$(document).ready(function() {
    $('#registrasi_table').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
    });
});
</script>