<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>LIST PROFILE LAYANAN</h1>
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
            <div class="col-md-3 order-sm-2">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body">
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <div class="form-group required">
                                <label for="fnama_profile" class="control-label">Nama Profile</label>
                                <input type="text"
                                    class="form-control <?= form_error('fnama_profile') ? 'is-invalid' : '' ?>"
                                    id="fnama_profile" name="fnama_profile" placeholder="Nama profile layanan"
                                    value="<?= $this->input->post('fnama_profile'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fnama_profile') ?>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label for="fmikrotik_group" class="control-label">Mikrotik Group</label>
                                <input type="text"
                                    class="form-control <?= form_error('fmikrotik_group') ? 'is-invalid' : '' ?>"
                                    id="fmikrotik_group" name="fmikrotik_group" placeholder="Mikrotik group"
                                    value="<?= $this->input->post('fmikrotik_group'); ?>">
                                <div class="form-text small text-muted">Harus sama dengan nama profile di
                                    mikrotik</div>
                                <div class="invalid-feedback">
                                    <?= form_error('fmikrotik_group') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="frate_limit" class="control-label">Mikrotik Rate Limit</label>
                                <input type="text"
                                    class="form-control <?= form_error('frate_limit') ? 'is-invalid' : '' ?>"
                                    id="frate_limit" name="frate_limit" placeholder="Mikrotik rate limit"
                                    value="1500k/2M 0/0 0/0 0/0 8 0/0">
                                <div class="form-text small text-muted">Jika dikosongkan, maka akan digunakan
                                    limitasi
                                    profile mikrotik</div>
                                <div class="invalid-feedback">
                                    <?= form_error('frate_limit') ?>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label for="fshared" class="control-label">Shared</label>
                                        <input type="number" min="1"
                                            class="form-control <?= form_error('fshared') ? 'is-invalid' : '' ?>"
                                            id="fshared" name="fshared" placeholder="Shared" value="1">
                                        <div class="invalid-feedback">
                                            <?= form_error('fshared') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label for="fmasa_aktif" class="control-label">Masa Aktif (Hari)</label>
                                        <input type="number" min="1"
                                            class="form-control <?= form_error('fmasa_aktif') ? 'is-invalid' : '' ?>"
                                            id="fmasa_aktif" name="fmasa_aktif" placeholder="Masa aktif" value="30">
                                        <div class="invalid-feedback">
                                            <?= form_error('fmasa_aktif') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label for="fkomisi" class="control-label">Komisi</label>
                                        <input type="text"
                                            class="form-control <?= form_error('fkomisi') ? 'is-invalid' : '' ?>"
                                            id="fkomisi" name="fkomisi" placeholder="Komisi" value="0">
                                        <div class="form-text small text-muted">Komisi reseller yang akan dikeuarkan
                                            tiap
                                            pembayaran <br> (Isi 0 jika hitungan komisi dalam bentuk persentase)</div>
                                        <div class="invalid-feedback">
                                            <?= form_error('fkomisi') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label for="fharga" class="control-label">Harga</label>
                                        <input type="text"
                                            class="form-control <?= form_error('fharga') ? 'is-invalid' : '' ?>"
                                            id="fharga" name="fharga" placeholder="Harga" value="0">
                                        <div class="form-text small text-muted">Harga diluar PPN</div>
                                        <div class="invalid-feedback">
                                            <?= form_error('fharga') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary float-right">Tambah</button>

                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-9 order-sm-1">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body table-responsive-xs">
                        <table id="tableUSer" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NAMA PROFILE</th>
                                    <th>GROUP</th>
                                    <th>RATE LIMIT</th>
                                    <th>SHARED</th>
                                    <th>AKTIF</th>
                                    <th>HPP</th>
                                    <th>KOMISI</th>
                                    <th>HARGA</th>
                                    <th>AKTIF</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($profile as $key): ?>
                                    <tr>
                                        <td class="text-uppercase">
                                            <?= $key->nama_profile ?>

                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->mikrotik_group ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->rate_limit ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->shared ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->masa_aktif ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->harga + $key->komisi ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->komisi ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->harga ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <span
                                                class="badge badge-pill <?= $key->is_aktif == 1 ? 'badge-success' : 'badge-danger' ?>">
                                                <?= $key->is_aktif == 1 ? 'Y' : 'N' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-primary dropdown-toggle dropdown-icon btn-xs"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                        MODIFY
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item" href="#"
                                                            onclick="deleteConfirm('<?= base_url() . 'profile_layanan/delete/' . encrypt_url($key->id_profile_layanan) ?>')">DELETE</a>
                                                        <a class="dropdown-item" <?php $val = $key->is_aktif == 0 ? 1 : 0; ?>
                                                            href="<?= base_url() . 'profile_layanan/set_status/' . encrypt_url($key->id_profile_layanan) . '/' . $val ?>"><?= $key->is_aktif == 1 ? 'NON AKTIF' : 'SET AKTIF' ?></a>

                                                    </div>
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
<script type="text/javascript">
    function deleteConfirm(url) {
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }

    //form field harga
    var harga = document.getElementById('fharga');
    harga.addEventListener('keyup', function (e) {
        harga.value = formatRupiah(this.value);
    });
    //form field komisi
    var komisi = document.getElementById('fkomisi');
    komisi.addEventListener('keyup', function (e) {
        komisi.value = formatRupiah(this.value);
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