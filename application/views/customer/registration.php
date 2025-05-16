<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-2">DATA REGISTRASI PELANGGAN</h1>
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
                        <table id="tableUSer" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 15px">No</th>
                                    <th>NO REGISTRASI</th>
                                    <th>JENIS REGIS</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>WHATSAPP</th>
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
                                foreach ($customers as $key) : ?>
                                    <tr>
                                        <td>
                                            <?= $no++ ?>
                                        </td>
                                        <td>
                                            <?= $key->nomor_registrasi ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->jenis_formulir) ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->nama_lengkap) ?>
                                        </td>
                                        <td>
                                            <?= $key->whatsapp ?>
                                        </td>
                                        <td>
                                            <?= $key->nomor_identitas ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->jenis_identitas) ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->alamat_identitas) ?>
                                        </td>
                                        <td>
                                            <?= $key->nomor_npwp ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    OPSI
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="<?= base_url() . 'registrasi/edit/' . encrypt_url($key->id_registrasi_customer) ?>" title="EDIT DATA" target="_blank" class="dropdown-item">
                                                        <div class="row">
                                                            <div class="col-2"><i class="fas fa-edit fa-sm"></i></div>
                                                            <div class="col">EDIT DATA</div>
                                                        </div>
                                                    </a>

                                                    <a href="<?= base_url() . 'customer/detail_registrasi/' . encrypt_url($key->id_registrasi_customer) ?>" target="_blank" class="dropdown-item">
                                                        <div class="row">
                                                            <div class="col-2"><i class="fas fa-file-pdf fa-sm"></i></div>
                                                            <div class="col text-capitalize">EXPORT PDF</div>
                                                        </div>
                                                    </a>
                                                    <a href="#" onclick="deleteConfirm('<?= base_url() . 'registrasi/delete/' . encrypt_url($key->id_registrasi_customer) ?>')" class="dropdown-item">
                                                        <div class="row">
                                                            <div class="col-2"><i class="fas fa-trash fa-sm"></i></div>
                                                            <div class="col">DELETE DATA</div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>



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
<!-- END MODAL UBAH -->
<script type="text/javascript">
    function deleteConfirm(url) {
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
</script>