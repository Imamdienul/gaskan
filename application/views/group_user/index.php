<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-2">GROUP USER</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-primary mt-2" href="<?= base_url('users/list') ?>">KEMBALI</a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body">
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <div class="form-group">
                                <label for="fgroup_user">Tambah Group User</label>
                                <input type="text"
                                    class="form-control <?= form_error('fgroup_user') ? 'is-invalid' : '' ?>"
                                    id="fgroup_user" name="fgroup_user" placeholder="Group user"
                                    value="<?= $this->input->post('fgroup_user'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fgroup_user') ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-right">Tambah</button>

                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body table-responsive-sm">
                        <table id="TabelUser" class="table table-condensed table-sm ">
                            <thead>
                                <tr>
                                    <th>ID Group</th>
                                    <th>Group User</th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($group_user as $key): ?>
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary">
                                                <?= $key->id_group_user ?>
                                            </span>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->group_user ?>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-danger"
                                                onclick="deleteConfirm('<?= base_url() . 'group_users/delete/' . encrypt_url($key->id_group_user) ?>')">DELETE</a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

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