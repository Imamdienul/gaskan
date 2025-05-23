<section class="content-header align-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="mt-2">LIST PENGGUNA</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-primary mt-2" href="<?= base_url('users/create') ?>">TAMBAH USER</a>
                    <a class="btn btn-md btn-primary mt-2" href="<?= base_url('group_users') ?>">GROUP USER</a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body table-responsive-sm">

                        <table id="tableUSer" class="display nowrap " style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 15px">No</th>
                                    <th>NIK</th>
                                    <th>NAMA</th>
                                    <th>EMAIL</th>
                                    <th>PHONE</th>
                                    <th>GROUP</th>
                                    <th>AKTIF</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($users as $key): ?>
                                    <tr class="text-uppercase">
                                        <td>
                                            <?= $no++ ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('users/detail/') . encrypt_url($key->id_user) ?>">
                                                <?= $key->nik ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?= $key->nama_user ?>
                                        </td>
                                        <td>
                                            <?= $key->email_user ?>
                                        </td>
                                        <td>
                                            <?= $key->phone_user ?>
                                        </td>
                                        <td>
                                            <?= $key->group_user ?>
                                        </td>
                                        <td>

                                            <span
                                                class="badge badge-pill <?= $key->status_user == 1 ? "badge-success" : "badge-danger" ?>"><?= $key->status_user == 1 ? "Y" : "N" ?></span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-danger"
                                                onclick="deleteConfirm('<?= base_url() . 'users/delete/' . encrypt_url($key->id_user) ?>')">delete</a>

                                            <?php
                                            $value = $key->status_user == 1 ? '0' : '1' ?>
                                            <a href="<?= base_url() . 'users/aktif_nonaktif/' . encrypt_url($key->id_user) . '/' . $value ?>"
                                                class="btn btn-xs <?= $key->status_user == 1 ? 'btn-warning' : 'btn-primary' ?>">
                                                <?= $key->status_user == 1 ? 'NON AKTIFKAN' : 'AKTIFKAN' ?>
                                            </a>
                                            <a href="<?= base_url() . 'users/edit_role/' . encrypt_url($key->id_user) ?>" 
   class="btn btn-xs btn-info">EDIT ROLE</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>

        </div>
    </div>
</section>

<!--Delete Confirmation-->
<div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-3 d-flex justify-content-center">
                        <i class="fa  fa-exclamation-triangle" style="font-size: 70px; color:red;"></i>
                    </div>
                    <div class="col-9 pt-2">
                        <h5>Apakah anda yakin?</h5>
                        <span>Data yang dihapus tidak akan bisa dikembalikan.</span>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"> Batal</button>
                <a id="btn-delete" class="btn btn-danger" href="#"> Hapus</a>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirm -->
<script type="text/javascript">
    function deleteConfirm(url) {
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }

</script>