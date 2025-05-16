<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>BUAT DATA PROJECT</h1>
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
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <div class="form-group required">
                                <label class="control-label" for="fno_spk">Nomor SPK/PO</label>
                                <input type="text"
                                    class="form-control <?= form_error('fno_spk') ? 'is-invalid' : '' ?> text-uppercase"
                                    id="fno_spk" name="fno_spk" placeholder="Nomor SPK / PO"
                                    value="<?= $this->input->post('fno_spk'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fno_spk') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fnama_project">Nama Project</label>
                                <input type="text"
                                    class="form-control <?= form_error('fnama_project') ? 'is-invalid' : '' ?> text-uppercase"
                                    id="fnama_project" name="fnama_project" placeholder="Nama project"
                                    value="<?= $this->input->post('fnama_project'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fnama_project') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fproject_manager">Project Manager</label>
                                <select
                                    class="form-control <?php echo form_error('fproject_manager') ? 'is-invalid' : '' ?>"
                                    id="fproject_manager" name="fproject_manager">
                                    <option hidden value="" selected>PILIH USER</option>
                                    <?php foreach ($user as $key): ?>
                                        <option value="<?= $key->id_user ?>"
                                            <?= $this->input->post('fproject_manager') == $key->id_user ? 'selected' : '' ?>>
                                            <?= strtoupper($key->nama_user) ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fproject_manager') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fproject_owner">Project Owner</label>
                                <input type="text"
                                    class="form-control <?= form_error('fproject_owner') ? 'is-invalid' : '' ?> text-uppercase"
                                    id="fproject_owner" name="fproject_owner" placeholder="Project owner"
                                    value="<?= $this->input->post('fproject_owner'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fproject_owner') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fproject_deadline">Project Deadline</label>
                                <input type="date"
                                    class="form-control <?= form_error('fproject_deadline') ? 'is-invalid' : '' ?>"
                                    id="fproject_deadline" name="fproject_deadline" placeholder="Deadline project"
                                    value="<?= $this->input->post('fproject_deadline'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fproject_deadline') ?>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="control-label" for="fproject_value">Nilai Project</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text"
                                        class="form-control <?= form_error('fproject_value') ? 'is-invalid' : '' ?>"
                                        id="fproject_value" name="fproject_value" placeholder="Nilai project"
                                        value="<?= $this->input->post('fproject_value'); ?>">
                                    <div class=" invalid-feedback">
                                        <?= form_error('fproject_value') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="fproject_location" class="control-label">Lokasi Project</label>
                                <textarea name="fproject_location"
                                    class="form-control <?= form_error('fproject_location') ? 'is-invalid' : '' ?> "
                                    id="fproject_location"
                                    placeholder="Alamat project"><?= $this->input->post('fproject_location'); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= form_error('fproject_location') ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right mt-2">Simpan</button>
                            <a href="<?= base_url('project') ?>" class="btn btn-secondary float-left mt-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    //form field rupiah
    var tanpa_rupiah = document.getElementById('fproject_value');
    tanpa_rupiah.addEventListener('keyup', function (e) {
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

    $(document).ready(function () {
        $('#fkeperluan').change(function () {

            var id = $(this).val();
            $.ajax({
                url: "<?= base_url() . 'kasbon/get_default_nominal/' ?>" + id,
                method: "GET",
                async: false,
                success: function (data) {
                    console.log(data)
                    $('#fnominal').val(formatRupiah(data))
                    if (data != 0) {
                        $('#fnominal').prop('readonly', true)
                    } else {
                        $('#fnominal').prop('readonly', false)

                    }
                }
            });
        });
    });

</script>