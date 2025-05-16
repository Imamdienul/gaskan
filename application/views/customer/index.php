<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-2">LIST PELANGGAN</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-primary mt-2" href="<?= base_url('customer/create_from_registrasi') ?>">TAMBAH
                        PELANGGAN</a>
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
                        <table id="tableUSer" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 15px">No</th>
                                    <th>ID PELANGGAN</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>TELEPON</th>
                                    <th>NO IDENTITAS</th>
                                    <th>JENIS IDENTITAS</th>
                                    <th>ALAMAT</th>
                                    <th>NO NPWP</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($customers as $key): ?>
                                    <tr>
                                        <td>
                                            <?= $no++ ?>
                                        </td>
                                        <td>
                                            <?= $key->id_customer ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->fullname) ?>
                                        </td>
                                        <td>
                                            <?= $key->phone_customer ?>
                                        </td>
                                        <td>
                                            <?= $key->no_id ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->jenis_id) ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->alamat_id) ?>
                                        </td>
                                        <td>
                                            <?= $key->no_npwp ?>
                                        </td>
                                        <td>
                                            <a href="#"
                                                onclick="deleteConfirm('<?= base_url() . 'customer/delete/' . encrypt_url($key->uid_customer) ?>')"
                                                class="btn btn-xs btn-danger">DELETE</a>
                                            <a href="<?= base_url() . 'customer/edit/' . encrypt_url($key->uid_customer) ?>"
                                                class="btn btn-xs btn-primary">EDIT</a>
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