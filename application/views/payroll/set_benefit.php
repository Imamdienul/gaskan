<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>SET BENEFIT KARYAWAN</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-default mt-2" href="<?= base_url('payroll') ?>">KEMBALI</a>
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
                    <!-- card-body -->
                    <div class="card-body">
                        <form role="form" method="POST" action="" autocomplete="off">
                            <div class="form-group ">
                                <label class="control-label" for="fname_user">Nama Lengkap</label>
                                <input type="text" class="form-control" value="<?= strtoupper($user->nama_user) ?>" disabled>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="fname_user">Email</label>
                                <input type="text" class="form-control" value="<?= strtoupper($user->email_user) ?>" disabled>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="fname_user">Handphone</label>
                                <input type="text" class="form-control" value="<?= strtoupper($user->phone_user) ?>" disabled>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label" for="fname_user">Rekening</label>
                                        <input type="text" class="form-control" value="<?= strtoupper($user->no_rekening) ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label" for="fname_user">Bank</label>
                                        <input type="text" class="form-control" value="<?= strtoupper($user->bank) ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="control-label" for="fname_user">Tanggal Join</label>
                                <input type="text" class="form-control" value="<?= TanggalIndo($user->tgl_join) ?>" disabled>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="fname_user">Username</label>
                                <input type="text" class="form-control" value="<?= strtoupper($user->username) ?>" disabled>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="fname_user">Group User</label>
                                <input type="text" class="form-control" value="<?= strtoupper($user->group_user) ?>" disabled>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group required">
                                        <label class="control-label" for="fkode_benefit">Kode Benefit</label>
                                        <select class="form-control <?php echo form_error('fkode_benefit') ? 'is-invalid' : '' ?>" id="fkode_benefit" name="fkode_benefit">
                                            <option hidden value="" selected>Pilih Kode Benefit </option>
                                            <option value="001">001 - Gaji Pokok</option>
                                            <option value="002">002 - Tunjuangan Lainnya</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= form_error('fkode_benefit') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group required">
                                        <label class="control-label" for="fnama_benefit">Keterangan Benefit</label>
                                        <input type="text" class="form-control <?= form_error('fnama_benefit') ? 'is-invalid' : '' ?>" id="fnama_benefit" name="fnama_benefit" placeholder="Keterangan benefit" value="<?= $this->input->post('fnama_benefit'); ?>">
                                        <div class="invalid-feedback">
                                            <?= form_error('fnama_benefit') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fnominal_benefit">Nominal</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control <?= form_error('fnominal_benefit') ? 'is-invalid' : '' ?>" id="fnominal_benefit" name="fnominal_benefit" placeholder="Nominal benefit">
                                    <div class=" invalid-feedback">
                                        <?= form_error('fnominal_benefit') ?>
                                    </div>
                                </div>
                                <div class="form-text small text-muted mt-n2">Nominal benefit untuk perbulan</div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">TAMBAH</button>
                        </form>
                    </div>
                </div>

                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body table-responsive-sm">
                        <table id="TabelUser" class="table table-condensed table-sm ">
                            <thead>
                                <tr>
                                    <th>KODE</th>
                                    <th>BENEFIT</th>
                                    <th>NOMINAL</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($benefit as $key) : ?>
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary">
                                                <?= $key->kode_benefit ?>
                                            </span>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->nama_benefit ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= rupiah($key->nominal_benefit) ?>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-danger" onclick="deleteConfirm('<?= base_url() . 'payroll/delete_benefit/' . encrypt_url($key->id_benefit) ?>')">DELETE</a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                        </table>
                    </div>
                </div>
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
<script>
    function deleteConfirm(url) {
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
    //form field rupiah
    var tanpa_rupiah = document.getElementById('fnominal_benefit');
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