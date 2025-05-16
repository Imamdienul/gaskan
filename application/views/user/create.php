<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-2">TAMBAH PENGGUNA</h1>
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
                                <label class="control-label" for="fname_user">Nama Lengkap</label>
                                <input type="text"
                                    class="form-control <?= form_error('fname_user') ? 'is-invalid' : '' ?>"
                                    id="fname_user" name="fname_user" placeholder="Nama lengkap"
                                    value="<?= $this->input->post('fname_user'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fname_user') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="femail_user">Email</label>
                                <input type="email"
                                    class="form-control <?= form_error('femail_user') ? 'is-invalid' : '' ?>"
                                    id="femail_user" name="femail_user" placeholder="Alamat email"
                                    value="<?= $this->input->post('femail_user'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('femail_user') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fphone_user">No. Handphone</label>
                                <input type="text"
                                    class="form-control <?= form_error('fphone_user') ? 'is-invalid' : '' ?>"
                                    id="fphone_user" name="fphone_user" placeholder="Contoh : 087776123870"
                                    value="<?= $this->input->post('fphone_user'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fphone_user') ?>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="fno_rekening">No. Rekening</label>
                                <input type="text"
                                    class="form-control <?= form_error('fno_rekening') ? 'is-invalid' : '' ?>"
                                    id="fno_rekening" name="fno_rekening" placeholder="Nomor rekening"
                                    value="<?= $this->input->post('fno_rekening'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fno_rekening') ?>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="fbank">Bank</label>
                                <select class="form-control <?php echo form_error('fbank') ? 'is-invalid' : '' ?>"
                                    id="fbank" name="fbank">
                                    <option hidden value="" selected>Pilih Bank </option>
                                    <option value="bri">BRI</option>
                                    <option value="mandiri">MANDIRI</option>
                                    <option value="bca">BCA</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fbank') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="ftgl_join">Tanggal Join</label>
                                <input type="date"
                                    class="form-control <?= form_error('ftgl_join') ? 'is-invalid' : '' ?>"
                                    id="ftgl_join" name="ftgl_join" placeholder="Tanggal join"
                                    value="<?= $this->input->post('ftgl_join'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('ftgl_join') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fusername">Username</label>
                                <input type="text"
                                    class="form-control <?= form_error('fusername') ? 'is-invalid' : '' ?>"
                                    id="fusername" name="fusername" placeholder="Username"
                                    value="<?= $this->input->post('fusername'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fusername') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fpassword">Password</label>
                                <input type="password"
                                    class="form-control <?= form_error('fpassword') ? 'is-invalid' : '' ?>"
                                    id="fpassword" name="fpassword" placeholder="Password"
                                    value="<?= $this->input->post('fpassword'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fpassword') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fconfpassword">Konfirmasi Password</label>
                                <input type="password"
                                    class="form-control <?= form_error('fconfpassword') ? 'is-invalid' : '' ?>"
                                    id="fconfpassword" name="fconfpassword" placeholder="Password"
                                    value="<?= $this->input->post('fconfpassword'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fconfpassword') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fid_group_user">Group User</label>
                                <select
                                    class="form-control <?php echo form_error('fid_group_user') ? 'is-invalid' : '' ?>"
                                    id="fid_group_user" name="fid_group_user">
                                    <option hidden value="" selected>Pilih Group </option>
                                    <?php foreach ($group_user as $key): ?>
                                        <option value="<?= $key->id_group_user ?>"
                                            <?= $this->input->post('fid_group_user') == $key->id_group_user ? 'selected' : '' ?>>
                                            <?= $key->group_user ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fid_group_user') ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right mt-2">Tambah</button>
                            <a href="<?= base_url('users/list') ?>" class="btn btn-secondary float-left mt-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>