<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-2">EDIT KATEGORI KEUANGAN</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-primary mt-2" href="<?= base_url('kasbon/kategori_keuangan') ?>">KEMBALI</a>
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
            <div class="col-md-4">
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex justify-content-between ">
                            <h5 class="text-warning ">EDIT KATEGORI KEUANGAN [ID <?= $data->id_kategori_keuangan ?>]</h5>
                            <a href="<?= base_url('kasbon/kategori_keuangan') ?>" class="btn btn-sm btn-default float-right">Batal</a>
                        </div>
                    </div>
                    <!-- card-body -->
                    <div class="card-body">
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <div class="form-group required">
                                <label class="control-label" for="fkategori_keuangan">Tambah Kategori Keuangan</label>
                                <input type="text" class="form-control <?= form_error('fkategori_keuangan') ? 'is-invalid' : '' ?>" id="fkategori_keuangan" name="fkategori_keuangan" placeholder="Kategori keuangan" value="<?= strtoupper($data->kategori_keuangan) ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fkategori_keuangan') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fnominal">Nominal</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control <?= form_error('fnominal') ? 'is-invalid' : '' ?>" id="fnominal" name="fnominal" placeholder="Nominal" value="<?= $data->default_nominal ?>">
                                    <div class=" invalid-feedback">
                                        <?= form_error('fnominal') ?>
                                    </div>
                                </div>
                                <div class="form-text small text-muted mt-n2">Isi 0 jika tidak ada nominal default</div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Update</button>

                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-8">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body table-responsive-sm">
                        <table id="TabelUser" class="table table-condensed table-sm ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>KATEGORI KEUANGAN</th>
                                    <th>DEFAULT NOMINAL</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($kategori as $key) : ?>
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary">
                                                <?= $key->id_kategori_keuangan ?>
                                            </span>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->kategori_keuangan ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= rupiah($key->default_nominal) ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('kasbon/edit_kategori_keuangan/') . encrypt_url($key->id_kategori_keuangan) ?>" class="btn btn-xs btn-primary">EDIT DATA</a>
                                            <a href="#" class="btn btn-xs btn-danger" onclick="deleteConfirm('<?= base_url() . 'kasbon/delete_kategori_keuangan/' . encrypt_url($key->id_kategori_keuangan) ?>')">DELETE</a>

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

    //form field rupiah
    var tanpa_rupiah = document.getElementById('fnominal');
    tanpa_rupiah.addEventListener('keyup', function(e) {
        tanpa_rupiah.value = formatRupiah(this.value);
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>