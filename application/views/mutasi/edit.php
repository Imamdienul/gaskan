<section class="content-header align-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="mt-2">DATA MUTASI BARANG</h1>
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
                        <table id="tableUSer" class="display nowrap " style="width:100%">
                            <thead>
                                <tr>

                                    <th>NO MUTASI</th>
                                    <th>NO REG.</th>
                                    <th>TGL MUTASI</th>
                                    <th>LOKASI</th>
                                    <th>NOTE</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($mutasi as $key) : ?>
                                    <tr>

                                        <td>
                                            <span class="badge badge-secondary text-uppercase">
                                                <?= $key->no_mutasi ?>
                                            </span>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->nomor_registrasi ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= TanggalIndo($key->tgl_mutasi)  ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->lokasi_barang ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $key->note ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('mutasi/edit/') . encrypt_url($key->id_mutasi) ?>" class="btn btn-xs btn-primary">EDIT MUTASI</a>
                                            <a href="#" class="btn btn-xs btn-danger" onclick="deleteConfirm('<?= base_url() . 'mutasi/delete_mutasi/' . encrypt_url($key->id_mutasi) ?>')">DELETE</a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- left column -->
            <div class="col-md-4">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body">
                        <h5 class="text-warning">EDIT DATA MUTASI BARANG</h5>
                        <hr>
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <div class="form-group required">
                                <label class="control-label" for="finventory">Nama Barang</label>
                                <div class="input-group ">
                                    <input type="text" class=" form-control <?php echo form_error('finventory') ? 'is-invalid' : '' ?>" id="finventory" name="finventory" onfocus="onFocus()" placeholder="Pilih nama barang" value="<?= strtoupper($data->nama_barang)  ?>">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-default " data-toggle="modal" data-target="#modal_barang"><i class="fas fa-search"></i></button>
                                    </span>
                                    <div class="invalid-feedback">
                                        <?= form_error('finventory') ?>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fbarang">No Registrasi</label>
                                <input type="text" class="form-control <?= form_error('fno_regis') ? 'is-invalid' : '' ?>" id="fno_regis" name="fno_regis" placeholder="No registrasi barang" value="<?= $data->nomor_registrasi ?>" readonly>
                                <div class="invalid-feedback">
                                    <?= form_error('fno_regis') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="ftgl_mutasi">Tanggal Mutasi</label>
                                <input type="date" class="form-control <?= form_error('ftgl_mutasi') ? 'is-invalid' : '' ?>" id="ftgl_mutasi" name="ftgl_mutasi" placeholder="Mac address" value="<?= $data->tgl_mutasi ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('ftgl_mutasi') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="flokasi_barang">Lokasi Barang</label>
                                <textarea name="flokasi_barang" class="form-control <?= form_error('flokasi_barang') ? 'is-invalid' : '' ?> text-uppercase" id="flokasi_barang"><?= $data->lokasi_barang ?></textarea>
                                <div class="invalid-feedback">
                                    <?= form_error('flokasi_barang') ?>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="fnote">Catatan</label>
                                <textarea name="fnote" class="form-control <?= form_error('fnote') ? 'is-invalid' : '' ?> text-uppercase" id="fnote"><?= $data->note ?></textarea>
                                <div class="invalid-feedback">
                                    <?= form_error('fnote') ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Update</button>

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

<!-- modal tipe barang -->
<div class="modal fade" id="modal_barang">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title text-bold">PILIH NAMA BARANG</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body" id="bodymodal_modal_tipe_barang">
                <div class="card-body table-responsive-sm">
                    <table id="tableOnModal" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>PILIH</th>
                                <th>NO REGIS.</th>
                                <th>BARANG</th>
                                <th>SERIAL NUMBER</th>
                                <th>MAC ADDRESS</th>
                                <th>SUPLYER</th>
                                <th>KONDISI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inventory as $key) : ?>
                                <tr class="text-uppercase">
                                    <td style="width: 10px;"><button class="btn btn-primary btn-sm" id="select" data-id="<?= $key->id_inventory ?>" data-barang="<?= $key->nama_barang ?>" data-sn="<?= $key->serial_number ?>" data-noregis="<?= $key->nomor_registrasi ?>">
                                            <i class=" fa fa-check"></i> Pilih
                                        </button>
                                    </td>
                                    <td>
                                        <?= $key->nomor_registrasi ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->nama_barang) ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->serial_number) ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->mac_address) ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->suplyer) ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->kondisi_barang) ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
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

    function onFocus() {
        $('#modal_barang').modal('show')
    }
    $(document).on('click', '#select', function() {
        var id = $(this).data('id');
        var barang = $(this).data('barang');
        var noregis = $(this).data('noregis');
        $('#finventory').val(barang.toUpperCase())
        $('#fno_regis').val(noregis)
        $('#modal_barang').modal('hide')
    })
    var tanpa_rupiah = document.getElementById('fharga_barang');
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