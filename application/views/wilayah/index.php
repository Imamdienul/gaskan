<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List Wilayah</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-primary " href="<?= base_url('customer/onbill') ?>">KEMBALI</a>
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
                            <div class="form-group required">
                                <label for="fnama_wilayah" class="control-label">Nama Wilayah</label>
                                <input type="text"
                                    class="form-control <?= form_error('fnama_wilayah') ? 'is-invalid' : '' ?>"
                                    id="fnama_wilayah" name="fnama_wilayah" placeholder="Nama wilayah"
                                    value="<?= $this->input->post('fnama_wilayah'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fnama_wilayah') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="fkecamatan" class="control-label">Kecamatan</label>
                                <input type="text"
                                    class="form-control <?= form_error('fkecamatan') ? 'is-invalid' : '' ?>"
                                    id="fkecamatan" name="fkecamatan" placeholder="Kecamatan"
                                    value="<?= $this->input->post('fkecamatan'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fkecamatan') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="fkabupaten" class="control-label">Kabupaten / Kota</label>
                                <input type="text"
                                    class="form-control <?= form_error('fkabupaten') ? 'is-invalid' : '' ?>"
                                    id="fkabupaten" name="fkabupaten" placeholder="kabupaten/kota"
                                    value="<?= $this->input->post('fkabupaten'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fkabupaten') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="fprovinsi" class="control-label">Provinsi</label>
                                <input type="text"
                                    class="form-control <?= form_error('fprovinsi') ? 'is-invalid' : '' ?>"
                                    id="fprovinsi" name="fprovinsi" placeholder="Provinsi"
                                    value="<?= $this->input->post('fprovinsi'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fprovinsi') ?>
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
                                    <th>ID ILAYAH</th>
                                    <th>NAMA WILAYAH</th>
                                    <th>KECAMATAN</th>
                                    <th>KABUPATEN/KOTA</th>
                                    <th>PROVINSI</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($wilayah as $key): ?>
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary">
                                                <?= $key->id_wilayah ?>
                                            </span>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->nama_wilayah ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->kecamatan ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->kabupaten ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->provinsi ?>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-danger"
                                                onclick="deleteConfirm('<?= base_url() . 'wilayah/delete/' . encrypt_url($key->id_wilayah) ?>')">DELETE</a>

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