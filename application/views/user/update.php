<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>UPDATE PROFILE SAYA</h1>
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
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <input type="hidden" name="fid_user" value="<?= encrypt_url($user->id_user) ?>"
                                style="display: none">
                            <div class="form-group required">
                                <label class="control-label" for="fname_user">Nama Lengkap</label>
                                <input type="text"
                                    class="form-control <?= form_error('fname_user') ? 'is-invalid' : '' ?>"
                                    id="fname_user" name="fname_user" placeholder="Nama lengkap"
                                    value="<?= strtoupper($user->nama_user) ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fname_user') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="femail_user">Email</label>
                                <input type="email"
                                    class="form-control <?= form_error('femail_user') ? 'is-invalid' : '' ?>"
                                    id="femail_user" name="femail_user" placeholder="Alamat email"
                                    value="<?= strtoupper($user->email_user) ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('femail_user') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fphone_user">No. Handphone</label>
                                <input type="text"
                                    class="form-control <?= form_error('fphone_user') ? 'is-invalid' : '' ?>"
                                    id="fphone_user" name="fphone_user" placeholder="Contoh : 087776123870"
                                    value="<?= strtoupper($user->phone_user) ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fphone_user') ?>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="fno_rekening">No. Rekening</label>
                                <input type="text"
                                    class="form-control <?= form_error('fno_rekening') ? 'is-invalid' : '' ?>"
                                    id="fno_rekening" name="fno_rekening" placeholder="Nomor rekening"
                                    value="<?= strtoupper($user->no_rekening) ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fno_rekening') ?>
                                </div>
                            </div>
                            <div class="form-group ">

                                <label class="control-label" for="fbank">Bank</label>
                                <select class="form-control <?php echo form_error('fbank') ? 'is-invalid' : '' ?>"
                                    id="fbank" name="fbank">
                                    <option hidden value="" selected>Pilih Bank</option>
                                    <?php $bank = $this->input->post('fbank') ? $this->input->post('fbank') : $user->bank ?>
                                    <option value="bri" <?= $bank == "bri" ? 'selected' : '' ?>>BRI</option>
                                    <option value="mandiri" <?= $bank == "mandiri" ? 'selected' : '' ?>>MANDIRI</option>
                                    <option value="bca" <?= $bank == "bca" ? 'selected' : '' ?>>BCA</option>
                                    <option value="dana" <?= $bank == "dana" ? 'selected' : '' ?>>DANA</option>

                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fbank') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="ftgl_join">Tanggal Join</label>
                                <input type="text"
                                    class="form-control <?= form_error('ftgl_join') ? 'is-invalid' : '' ?>"
                                    id="ftgl_join" name="ftgl_join" value="<?= TanggalIndo($user->tgl_join) ?>"
                                    disabled>

                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fusername">Username</label>
                                <input type="text"
                                    class="form-control <?= form_error('fusername') ? 'is-invalid' : '' ?>"
                                    id="fusername" name="fusername" value="<?= strtoupper($user->username) ?>" disabled>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fusername">Group User</label>
                                <input type="text"
                                    class="form-control <?= form_error('fgroup_user') ? 'is-invalid' : '' ?>"
                                    id="fgroup_user" name="fgroup_user" value="<?= strtoupper($user->group_user) ?>"
                                    disabled>
                            </div>
                            <button type="submit" class="btn btn-primary float-right mt-2">UPDATE</button>
                            <a href="<?= base_url('users/profile') ?>"
                                class="btn btn-secondary float-left mt-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>