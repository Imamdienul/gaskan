<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-2">EDIT MASTER TIPE BARANG</h1>
            </div>

        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body table-responsive-sm">
                        <table id="TabelUser" class="table table-condensed table-sm ">
                            <thead>
                                <tr>
                                    <th>KODE TIPE</th>
                                    <th>NAMA MEREK</th>
                                    <th>NAMA TIPE</th>
                                    <th>SPEKSIFIKASI</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($master_tipe as $key) : ?>
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary text-uppercase">
                                                <?= $key->kode_tipe ?>
                                            </span>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->nama_merek ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->nama_tipe ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->spesifikasi ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('inventory/edit_master_tipe/') . encrypt_url($key->id_master_tipe) ?>" class="btn btn-xs btn-primary">EDIT DATA</a>
                                            <a href="#" class="btn btn-xs btn-danger" onclick="deleteConfirm('<?= base_url() . 'inventory/delete_master_tipe/' . encrypt_url($key->id_master_tipe) ?>')">DELETE</a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- left column -->
            <div class="col-md-5">
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex justify-content-between ">
                            <h5 class="text-warning ">EDIT DATA TIPE BARANG [<?= $data->kode_tipe ?>]</h5>
                            <a href="<?= base_url('inventory/master_tipe') ?>" class="btn btn-sm btn-default float-right">Batal</a>
                        </div>
                    </div>
                    <!-- card-body -->
                    <div class="card-body">
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <div class="form-group required">
                                <label class="control-label" for="fkode_tipe">Kode Tipe</label>
                                <input type="text" class="form-control <?= form_error('fkode_tipe') ? 'is-invalid' : '' ?>" id="fkode_tipe" name="fkode_tipe" placeholder="Kode barang" value="<?= $data->kode_tipe ?>" readonly>
                                <div class="invalid-feedback">
                                    <?= form_error('fkode_tipe') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fnama_tipe">Nama Tipe</label>
                                <input type="text" class="form-control <?= form_error('fnama_tipe') ? 'is-invalid' : '' ?>" id="fnama_tipe" name="fnama_tipe" placeholder="Nama tipe" value="<?= $data->nama_tipe ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fnama_tipe') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fmerek">Merek</label>
                                <select class="form-control <?php echo form_error('fmerek') ? 'is-invalid' : '' ?>" id="fmerek" name="fmerek">
                                    <option hidden value="" selected>Pilih Merek </option>
                                    <?php foreach ($master_merek as $key) : ?>
                                        <option value="<?= $key->id_master_merek ?>" <?= $data->id_master_merek == $key->id_master_merek ? 'selected' : '' ?>><?= strtoupper($key->nama_merek) ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fmerek') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fspesifikasi">Spesifikasi</label>
                                <textarea name="fspesifikasi" class="form-control <?= form_error('fspesifikasi') ? 'is-invalid' : '' ?> text-uppercase" id="fspesifikasi"><?= $data->spesifikasi ?></textarea>
                                <div class="invalid-feedback">
                                    <?= form_error('fspesifikasi') ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Update</button>
                            <a class="btn btn-secondary " href="<?= base_url('inventory/master_tipe') ?>">Batal</a>

                        </form>
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