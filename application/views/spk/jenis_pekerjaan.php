<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-2">MASTER JENIS PEKERJAAN</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-primary mt-2" href="<?= base_url('spk') ?>">KEMBALI</a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body table-responsive-sm">
                        <table id="TabelUser" class="table table-condensed table-sm ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>JENIS PEKERJAAN</th>
                                    <th>NOMINAL</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($jenis_pekerjaan as $key) : ?>
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary">
                                                <?= $key->id_jenis_pekerjaan ?>
                                            </span>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->jenis_pekerjaan ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= rupiah($key->nominal) ?>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-danger" onclick="deleteConfirm('<?= base_url() . 'jenis_pekerjaan/delete_jenis_pekerjaan/' . encrypt_url($key->id_jenis_pekerjaan) ?>')">DELETE</a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-4">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body">
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <div class="form-group required">
                                <label class="control-label" for="fkategori_keuangan">Tambah Jenis Pekerjaan</label>
                                <input type="text" class="form-control <?= form_error('fjenis_pekerjaan') ? 'is-invalid' : '' ?>" id="fjenis_pekerjaan" name="fjenis_pekerjaan" placeholder="Jenis pekerjaan" value="<?= $this->input->post('fjenis_pekerjaan'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fjenis_pekerjaan') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fnominal">Nominal</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control <?= form_error('fnominal') ? 'is-invalid' : '' ?>" id="fnominal" name="fnominal" placeholder="Nominal" value="<?= $this->input->post('fjenis_pekerjaan'); ?>">
                                    <div class=" invalid-feedback">
                                        <?= form_error('fnominal') ?>
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Tambah</button>
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