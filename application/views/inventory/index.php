<section class="content-header align-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="mt-2">DATA INVENTORY</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-primary mt-2" href="<?= base_url('inventory/master_barang') ?>">MASTER BARANG</a>
                    <a class="btn btn-md btn-primary mt-2" href="<?= base_url('inventory/master_merek') ?>">MASTER MEREK</a>
                    <a class="btn btn-md btn-primary mt-2" href="<?= base_url('inventory/master_tipe') ?>">MASTER TIPE BARANG</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- FORM SECTION MOVED TO LEFT -->
            <div class="col-md-4">
                <div class="card">
                    <!-- card-body -->
                    <div class="card-body">
                        <h5 class="text-primary">TAMBAH DATA INVENTORY</h5>
                        <hr>
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <input type="hidden" name="fid_tipe" id="fid_tipe" style="display: none">
                            <div class="form-group required">
                                <label class="control-label" for="fbarang">Nama Barang</label>
                                <select class="form-control <?php echo form_error('fbarang') ? 'is-invalid' : '' ?>" id="fbarang" name="fbarang">
                                    <option hidden value="" selected>Pilih Barang </option>
                                    <?php foreach ($master_barang as $key) : ?>
                                        <option value="<?= $key->kode_barang     ?>"><?= $key->kode_barang . ' - ' . strtoupper($key->nama_barang) ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fbarang') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="ftipe">Merek Barang</label>
                                <div class="input-group ">
                                    <input type="text" class=" form-control <?php echo form_error('ftipe') ? 'is-invalid' : '' ?>" id="ftipe" name="ftipe" onfocus="onFocus()" placeholder="Pilih merek barang" value="<?= $this->input->post('ftipe'); ?>">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-default " data-toggle="modal" data-target="#modal_tipe_barang"><i class="fas fa-search"></i></button>
                                    </span>
                                    <div class="invalid-feedback">
                                        <?= form_error('ftipe') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fspesifikasi">Spesifikasi</label>
                                <input type="text" class="form-control <?= form_error('fspesifikasi') ? 'is-invalid' : '' ?>" id="fspesifikasi" name="fspesifikasi" placeholder="Spesifikasi barang" value="<?= $this->input->post('fspesifikasi'); ?>" readonly>
                                <div class="invalid-feedback">
                                    <?= form_error('fspesifikasi') ?>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="fserial_number">Serial Number</label>
                                <input type="text" class="form-control <?= form_error('fserial_number') ? 'is-invalid' : '' ?>" id="fserial_number" name="fserial_number" placeholder="Serial number" value="<?= $this->input->post('fserial_number'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fserial_number') ?>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="fmac_address">Mac Address</label>
                                <input type="text" class="form-control <?= form_error('fmac_address') ? 'is-invalid' : '' ?>" id="fmac_address" name="fmac_address" placeholder="Mac address" value="<?= $this->input->post('fmac_address'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fmac_address') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="ftgl_registrasi">Tanggal Registrasi</label>
                                <input type="date" class="form-control <?= form_error('ftgl_registrasi') ? 'is-invalid' : '' ?>" id="ftgl_registrasi" name="ftgl_registrasi" placeholder="Mac address" value="<?= date('d-m-y'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('ftgl_registrasi') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fsuplyer">Supplier</label>
                                <input type="text" class="form-control <?= form_error('fsuplyer') ? 'is-invalid' : '' ?>" id="fsuplyer" name="fsuplyer" placeholder="Supplier" value="<?= $this->input->post('fsuplyer'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fsuplyer') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fstatus_barang">Status Barang</label>
                                <select class="form-control <?php echo form_error('fstatus_barang') ? 'is-invalid' : '' ?>" id="fstatus_barang" name="fstatus_barang">
                                    <option hidden value="" selected>Pilih Status Barang </option>
                                    <option value="sewa" <?= $this->input->post('fstatus_barang') == 'sewa' ? 'selected' : '' ?>>SEWA </option>
                                    <option value="beli" <?= $this->input->post('fstatus_barang') == 'beli' ? 'selected' : '' ?>>BELI </option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fstatus_barang') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fjenis_barang">Jenis Barang</label>
                                <select class="form-control <?php echo form_error('fjenis_barang') ? 'is-invalid' : '' ?>" id="fjenis_barang" name="fjenis_barang">
                                    <option hidden value="" selected>Pilih Jenis Barang </option>
                                    <option value="habis pakai" <?= $this->input->post('fjenis_barang') == 'habis pakai' ? 'selected' : '' ?>>HABIS PAKAI </option>
                                    <option value="non habis pakai" <?= $this->input->post('fjenis_barang') == 'non habis pakai' ? 'selected' : '' ?>>NON HABIS PAKAI </option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fjenis_barang') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fharga_barang">Harga Barang</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control <?= form_error('fharga_barang') ? 'is-invalid' : '' ?>" id="fharga_barang" name="fharga_barang" placeholder="Harga barang" value="<?= $this->input->post('fharga_barang'); ?>">
                                    <div class=" invalid-feedback">
                                        <?= form_error('fharga_barang') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fkondisi_barang">Kondisi Barang</label>
                                <input type="text" class="form-control <?= form_error('fkondisi_barang') ? 'is-invalid' : '' ?>" id="fkondisi_barang" name="fkondisi_barang" placeholder="Kondisi barang" value="<?= $this->input->post('fkondisi_barang'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fkondisi_barang') ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- DATA TABLE SECTION (MOVED TO RIGHT) -->
            <div class="col-md-8">
                <div class="alert alert-dismissible alert-default-light">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Berikut adalah data stok barang yang tersedia (belum mutasi).<br>
                    Catatan : Ukuran label barcode adalah 30mm x 20mm.
                </div>
                <div class="card <?= $this->uri->segment(2) == 'filter' ? '' : 'collapsed-card' ?>">
                    <div class="card-header">
                        <h3 class="card-title mt-1">STOK INVENTORY</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-<?= $this->uri->segment(2) == 'filter' ? 'minus' : 'plus' ?>"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($stok as $key) : ?>
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-0"><?= strtoupper(substr($key->nama_barang, 0, 3)) ?></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><?= strtoupper($key->nama_barang) ?></span>
                                            <span class="info-box-number">
                                                <?= strtoupper($key->total) ?>
                                                <small>Unit</small>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body table-responsive-sm">
                        <form method="post" action="<?= base_url('inventory/barcode_multi') ?>" id="form-print" target="_blank">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <div class="bg-default mb-2 py-1 px-2">
                                <input type="checkbox" id="check-all"> <label for="check-all">SELECT ALL</label>
                                <button type="button" id="btn-print" class="btn btn-sm btn-primary ml-3" disabled><i class="fas fa-print"></i> PRINT BARCODE</button>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3" id="nama_barang"></div>
                                <div class="col-md-3" id="kategori"></div>
                            </div>
                            <?= $this->session->flashdata('pesan'); ?>
                            <table id="tableInventory" class="display nowrap " style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>NO REG.</th>
                                        <th>NAMA BARANG</th>
                                        <th>SERIAL NUMBER</th>
                                        <th>MAC ADDRESS</th>
                                        <th>SUPLYER</th>
                                        <th>STATUS</th>
                                        <th>JENIS</th>
                                        <th>KONDISI</th>
                                        <th>TGL REGISTRASI</th>
                                        <th>OPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($inventory as $key) : ?>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type='checkbox' class='check-item' name='noreg[]' value=<?= $key->nomor_registrasi ?>>
                                            </td>
                                            <td class="bg-primary text-lg">
                                                <?= $key->nomor_registrasi ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= $key->nama_barang ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= $key->serial_number ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= $key->mac_address ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= strtoupper($key->suplyer) ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= strtoupper($key->status_barang)  ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= strtoupper($key->jenis_barang) ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= strtoupper($key->kondisi_barang) ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= TanggalIndo($key->tgl_registrasi) ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('inventory/edit/') . encrypt_url($key->id_inventory) ?>" class="btn btn-xs btn-primary">EDIT DATA</a>
                                                <a data-toggle="modal" onclick="showMutasi('<?= $key->nomor_registrasi ?>')" href="#modal_mutasi" class="btn btn-primary btn-xs">
                                                    LIHAT MUTASI
                                                </a>
                                                <a href="<?= base_url('inventory/barcode/') . $key->nomor_registrasi ?>" class="btn btn-xs btn-success" target="_blank">BARCODE</a>
                                                <a href="#" class="btn btn-xs btn-danger" onclick="deleteConfirm('<?= base_url() . 'inventory/delete_inventory/' . encrypt_url($key->id_inventory) ?>')">DELETE</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </form>
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

<!-- modal tipe barang -->
<div class="modal fade" id="modal_tipe_barang">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title text-bold">PILIH TIPE BARANG</p>
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
                                <th>KODE TIPE</th>
                                <th>NAMA TIPE</th>
                                <th>MEREK</th>
                                <th>SPESIFIKASI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($master_tipe as $key) : ?>
                                <tr class="text-uppercase">
                                    <td style="width: 10px;"><button class="btn btn-primary btn-sm" id="select" data-id="<?= $key->id_master_tipe ?>" data-merek="<?= $key->nama_merek ?>" data-spesifikasi="<?= $key->spesifikasi ?>">
                                            <i class="fa fa-check"></i> Pilih
                                        </button>
                                    </td>
                                    <td>
                                        <?= $key->kode_tipe ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->nama_tipe) ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->nama_merek) ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->spesifikasi) ?>
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

<!-- Modal Mutasi-->
<div class="modal fade" id="modal_mutasi">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="bodymodal_mutasi">
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var the_terms = $(".check-item");

        the_terms.click(function() {
            if ($(this).is(":checked")) {
                $("#btn-print").removeAttr("disabled");
            } else {
                $("#btn-print").attr("disabled", "disabled");
            }
        });
        $("#check-all").click(function() {
            if ($(this).is(":checked")) {
                $(".check-item").prop("checked", true);
                $("#btn-print").removeAttr("disabled");
            } else {
                $(".check-item").prop("checked", false);
                $("#btn-print").attr("disabled", "disabled");
            }
        });

        $("#btn-print").click(function() {
            $("#form-print").submit();
        });
    });


function deleteConfirm(url) {

    document.getElementById('btn-delete').setAttribute('href', url);

    $('#deleteModal').modal('show');
}

    function onFocus() {
        $('#modal_tipe_barang').modal('show')
    }
    $(document).on('click', '#select', function() {
        var tipe_id = $(this).data('id');
        var merek = $(this).data('merek');
        var spesifikasi = $(this).data('spesifikasi');
        $('#ftipe').val(merek.toUpperCase())
        $('#fspesifikasi').val(spesifikasi.toUpperCase())
        $('#fid_tipe').val(tipe_id)
        $('#modal_tipe_barang').modal('hide')
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

    function showMutasi(noregis) {
        $.ajax({
            type: "get",
            url: "<?= site_url('inventory/show_mutasi/'); ?>" + noregis,
            dataType: "html",
            success: function(response) {
                $('#bodymodal_mutasi').empty();
                $('#bodymodal_mutasi').append(response);
            }
        });
    }
    $(document).ready(function() {
        $('form').on('keypress', function(e) {
            if (e.which === 13 && !$(e.target).is('textarea')) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>