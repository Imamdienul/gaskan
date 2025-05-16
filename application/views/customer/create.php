<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Pelanggan</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <!-- form start -->
                    <form role="form" method="POST" action="" autocomplete="off">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                        <div class="card-body">
                            <div class="form-group required">
                                <label for="fid_customer" class="control-label">ID Pelanggan</label>
                                <input type="text"
                                    class="form-control <?= form_error('fid_customer') ? 'is-invalid' : '' ?>"
                                    id="fid_customer" name="fid_customer" placeholder="ID Pelanggan"
                                    value="<?= $id_cust ?>" readonly>
                                <div class="invalid-feedback">
                                    <?= form_error('fid_customer') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="ffullname" class="control-label">Nama Lengkap</label>
                                <input type="text"
                                    class="form-control <?= form_error('ffullname') ? 'is-invalid' : '' ?>"
                                    id="ffullname" name="ffullname" placeholder="Nama lengkap"
                                    value="<?= $this->input->post('ffullname'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('ffullname') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="fphone_customer" class="control-label">Nomor Handphone</label>
                                <input type="text"
                                    class="form-control <?= form_error('fphone_customer') ? 'is-invalid' : '' ?>"
                                    id="fphone_customer" name="fphone_customer" placeholder="Nomor handphone"
                                    value="<?= $this->input->post('fphone_customer'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fphone_customer') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="fno_id" class="control-label">No. Identitas</label>
                                <input type="text" class="form-control <?= form_error('fno_id') ? 'is-invalid' : '' ?>"
                                    id="fno_id" name="fno_id" placeholder="Nomor identitas (KTP/SIM)"
                                    value="<?= $this->input->post('fno_id'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fno_id') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="fjenis_id" class="control-label">Jenis Indentitas</label>
                                <select class="form-control <?php echo form_error('fjenis_id') ? 'is-invalid' : '' ?>"
                                    id="fjenis_id" name="fjenis_id">
                                    <option hidden value="" selected>Pilih Identitas </option>
                                    <option value="ktp" <?= $this->input->post('fjenis_id') == "ktp" ? "selected" : "" ?>>
                                        KTP
                                    </option>
                                    <option value="sim" <?= $this->input->post('fjenis_id') == "sim" ? "selected" : "" ?>>
                                        SIM</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fjenis_id') ?>
                                </div>
                            </div>
                            
                            <!-- Wilayah Dropdown -->
                            <div class="form-group required">
                                <label for="fprovinsi" class="control-label">Provinsi</label>
                                <select class="form-control <?= form_error('fprovinsi') ? 'is-invalid' : '' ?>"
                                    id="fprovinsi" name="fprovinsi">
                                    <option hidden value="" selected>Pilih Provinsi</option>
                                    <?php foreach ($provinsi as $prov) : ?>
                                        <option value="<?= $prov->id ?>" <?= $this->input->post('fprovinsi') == $prov->id ? "selected" : "" ?>>
                                            <?= $prov->nama ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fprovinsi') ?>
                                </div>
                            </div>
                            
                            <div class="form-group required">
                                <label for="fkabupaten" class="control-label">Kabupaten/Kota</label>
                                <select class="form-control <?= form_error('fkabupaten') ? 'is-invalid' : '' ?>"
                                    id="fkabupaten" name="fkabupaten">
                                    <option hidden value="" selected>Pilih Kabupaten/Kota</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fkabupaten') ?>
                                </div>
                            </div>
                            
                            <div class="form-group required">
                                <label for="fkecamatan" class="control-label">Kecamatan</label>
                                <select class="form-control <?= form_error('fkecamatan') ? 'is-invalid' : '' ?>"
                                    id="fkecamatan" name="fkecamatan">
                                    <option hidden value="" selected>Pilih Kecamatan</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fkecamatan') ?>
                                </div>
                            </div>
                            
                            <div class="form-group required">
                                <label for="fdesa" class="control-label">Desa/Kelurahan</label>
                                <select class="form-control <?= form_error('fdesa') ? 'is-invalid' : '' ?>"
                                    id="fdesa" name="fdesa">
                                    <option hidden value="" selected>Pilih Desa/Kelurahan</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fdesa') ?>
                                </div>
                            </div>
                            
                            <div class="form-group required">
                                <label for="falamat_detail" class="control-label">Alamat Detail</label>
                                <textarea name="falamat_detail"
                                    class="form-control <?= form_error('falamat_detail') ? 'is-invalid' : '' ?> "
                                    id="falamat_detail"
                                    placeholder="Alamat detail (RT/RW, No. Rumah, Blok, dll)"><?= $this->input->post('falamat_detail'); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= form_error('falamat_detail') ?>
                                </div>
                            </div>
                            
                            <div class="form-group ">
                                <label for="fno_npwp">No. NPWP</label>
                                <input type="text"
                                    class="form-control <?= form_error('fno_npwp') ? 'is-invalid' : '' ?>" id="fno_npwp"
                                    name="fno_npwp" placeholder="Nomor NPWP"
                                    value="<?= $this->input->post('fno_npwp'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fno_npwp') ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                            <a href="<?= base_url('customer/browse') ?>" class="btn btn-secondary float-left">Batal</a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    // Fungsi untuk mengambil data kabupaten berdasarkan provinsi
    $('#fprovinsi').change(function() {
        var provinsi_id = $(this).val();
        if (provinsi_id != '') {
            $.ajax({
                url: '<?= base_url('customer/get_kabupaten') ?>',
                method: 'POST',
                data: {
                    provinsi_id: provinsi_id,
                    <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(data) {
                    $('#fkabupaten').empty();
                    $('#fkabupaten').append('<option value="" selected>Pilih Kabupaten/Kota</option>');
                    $.each(data, function(index, item) {
                        $('#fkabupaten').append('<option value="' + item.id + '">' + item.nama + '</option>');
                    });
                    $('#fkecamatan').empty();
                    $('#fkecamatan').append('<option value="" selected>Pilih Kecamatan</option>');
                    $('#fdesa').empty();
                    $('#fdesa').append('<option value="" selected>Pilih Desa/Kelurahan</option>');
                }
            });
        } else {
            $('#fkabupaten').empty();
            $('#fkabupaten').append('<option value="" selected>Pilih Kabupaten/Kota</option>');
            $('#fkecamatan').empty();
            $('#fkecamatan').append('<option value="" selected>Pilih Kecamatan</option>');
            $('#fdesa').empty();
            $('#fdesa').append('<option value="" selected>Pilih Desa/Kelurahan</option>');
        }
    });

    // Fungsi untuk mengambil data kecamatan berdasarkan kabupaten
    $('#fkabupaten').change(function() {
        var kabupaten_id = $(this).val();
        if (kabupaten_id != '') {
            $.ajax({
                url: '<?= base_url('customer/get_kecamatan') ?>',
                method: 'POST',
                data: {
                    kabupaten_id: kabupaten_id,
                    <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(data) {
                    $('#fkecamatan').empty();
                    $('#fkecamatan').append('<option value="" selected>Pilih Kecamatan</option>');
                    $.each(data, function(index, item) {
                        $('#fkecamatan').append('<option value="' + item.id + '">' + item.nama + '</option>');
                    });
                    $('#fdesa').empty();
                    $('#fdesa').append('<option value="" selected>Pilih Desa/Kelurahan</option>');
                }
            });
        } else {
            $('#fkecamatan').empty();
            $('#fkecamatan').append('<option value="" selected>Pilih Kecamatan</option>');
            $('#fdesa').empty();
            $('#fdesa').append('<option value="" selected>Pilih Desa/Kelurahan</option>');
        }
    });

    // Fungsi untuk mengambil data desa berdasarkan kecamatan
    $('#fkecamatan').change(function() {
        var kecamatan_id = $(this).val();
        if (kecamatan_id != '') {
            $.ajax({
                url: '<?= base_url('customer/get_desa') ?>',
                method: 'POST',
                data: {
                    kecamatan_id: kecamatan_id,
                    <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(data) {
                    $('#fdesa').empty();
                    $('#fdesa').append('<option value="" selected>Pilih Desa/Kelurahan</option>');
                    $.each(data, function(index, item) {
                        $('#fdesa').append('<option value="' + item.id + '">' + item.nama + '</option>');
                    });
                }
            });
        } else {
            $('#fdesa').empty();
            $('#fdesa').append('<option value="" selected>Pilih Desa/Kelurahan</option>');
        }
    });
});
</script>