<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>BUAT PENGAJUAN KEUANGAN</h1>
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
                        <form role="form" method="POST" action="" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">

                            <div class="form-group required">
                                <label class="control-label" for="fno_dokumen">No. Dokumen</label>
                                <input type="text" class="form-control" id="fno_dokumen" name="fno_dokumen" value="<?= strtoupper(sprintf("%04d", $no_urut) . '/FN/' . bulanRomawi(date('m')) . '/' . date('Y')) ?>" readonly>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label class="control-label" for="fnik">NIK</label>
                                        <input type="text" class="form-control" id="fnik" name="fnik" value="<?= strtoupper($this->session->userdata('nik')) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group required">
                                        <label class="control-label" for="fname_user">Nama Lengkap</label>
                                        <input type="text" class="form-control <?= form_error('fname_user') ? 'is-invalid' : '' ?>" id="fname_user" name="fname_user" value="<?= strtoupper($this->session->userdata('nama_user')) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fkeperluan">Kategori Keuangan</label>
                                <select class="form-control <?php echo form_error('fkeperluan') ? 'is-invalid' : '' ?>" id="fkeperluan" name="fkeperluan">
                                    <option hidden value="" selected>Pilih Kategori Keuangan </option>
                                    <?php foreach ($kategori_keuangan as $key) : ?>
                                        <option value="<?= $key->id_kategori_keuangan ?>">
                                            <?= strtoupper($key->kategori_keuangan) ?>
                                        </option>
                                    <?php endforeach ?>

                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fkeperluan') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fnominal">Nominal</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control <?= form_error('fnominal') ? 'is-invalid' : '' ?>" id="fnominal" name="fnominal" placeholder="Nominal" value="<?= $this->input->post('fnominal'); ?>">
                                    <div class=" invalid-feedback">
                                        <?= form_error('fnominal') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="control-label" for="fcara_pencairan">Cara Pencairan</label>
                                <select class="form-control <?php echo form_error('fcara_pencairan') ? 'is-invalid' : '' ?>" id="fcara_pencairan" name="fcara_pencairan">
                                    <option hidden value="" selected>Pilih Pencairan </option>
                                    <option value="cash">CASH</option>
                                    <option value="transfer bank">TRANSFER BANK</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fcara_pencairan') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fnama_project">Project</label>
                                <div class="input-group ">
                                    <input type="text" class=" form-control <?php echo form_error('fnama_project') ? 'is-invalid' : '' ?>" id="fnama_project" name="fnama_project" onfocus="onFocus()" placeholder="Pilih project">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-default " data-toggle="modal" data-target="#modal_project"><i class="fas fa-search"></i></button>
                                    </span>


                                </div>
                                <span class="text-xs text-red">
                                    <?= form_error('fid_project') ?>
                                </span>
                            </div>
                            <div class="form-group required">
                                <div class="input-group ">
                                    <input type="hidden" name="fid_project" id="fid_project" style="display: none">
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="flampiran">Lampiran Pengajuan</label>
                                <input type="file" class="pb-4 form-control <?= form_error('flampiran') ? 'is-invalid' : '' ?>" id="flampiran" name="flampiran">
                                <small id="flampiran" class="form-text text-muted">Format file harus .pdf .png .jpg .jpeg, ukuran
                                    maksimal 2Mb </small>
                            </div>
                            <div class="form-group ">
                                <label for="fnote">Catatan</label>
                                <textarea name="fnote" class="form-control <?= form_error('fnote') ? 'is-invalid' : '' ?> text-uppercase" id="fnote"><?= $this->input->post('fnote'); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= form_error('fnote') ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right mt-2">Buat Pengajuan</button>
                            <a href="<?= base_url('kasbon') ?>" class="btn btn-secondary float-left mt-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- modal project -->
<div class="modal fade" id="modal_project">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title text-bold">PILIH PROJECT</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bodymodal_modal_project">
                <div class="card-body table-responsive-sm">
                    <table id="tableOnModal" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>PILIH</th>
                                <th>NO SPK/PO</th>
                                <th>PROJECT</th>
                                <th>OWNER</th>
                                <th>PROJECT MANAGER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($project as $key) : ?>
                                <tr class="text-uppercase">
                                    <td style="width: 5px;"><button class="btn btn-primary btn-sm" id="select" data-id="<?= $key->project_id ?>" data-nama="<?= $key->nama_project ?>">
                                            <i class="fa fa-check"></i> Pilih
                                        </button>
                                    </td>
                                    <td>
                                        <?= $key->nomor_spk ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->nama_project) ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->project_owner) ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->nama_user) ?>
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
<script>
    function onFocus() {
        $('#modal_project').modal('show')
    }
    $(document).on('click', '#select', function() {
        var id = $(this).data('id');
        var namaProject = $(this).data('nama');
        $('#fid_project').val(id)
        $('#fnama_project').val(namaProject.toUpperCase())
        $('#modal_project').modal('hide')
    })
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

    $(document).ready(function() {
        $('#fkeperluan').change(function() {

            var id = $(this).val();
            $.ajax({
                url: "<?= base_url() . 'kasbon/get_default_nominal/' ?>" + id,
                method: "GET",
                async: false,
                success: function(data) {

                    $('#fnominal').val(formatRupiah(data))
                    if (data != 0) {
                        $('#fnominal').prop('readonly', true)
                        $('#flampiran').prop('required', true)
                    } else {
                        $('#fnominal').prop('readonly', false)
                        $('#flampiran').prop('required', false)


                    }
                }
            });

        });
    });
</script>