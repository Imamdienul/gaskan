<section class="content-header align-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Pengaturan</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="list-group">
                    <a href="<?= base_url('pengaturan/ganti_pass') ?>"
                        class="list-group-item list-group-item-action <?= $this->uri->segment(2) == 'ganti_pass' ? 'active' : '' ?>">
                        Ganti Password
                    </a>
                    <a href="<?= base_url('pengaturan/whatsapp') ?>"
                        class="list-group-item list-group-item-action <?= $this->uri->segment(2) == 'whatsapp' ? 'active' : '' ?>">Pengaturan
                        Whatsapp</a>
                    <!-- <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
                    <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
                    <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum at eros</a> -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="callout callout-success">
                            <h5>Pengaturan Whatsapp</h5>
                            <p>Merubah nomor wa tujuan untuk notifikasi
                            </p>
                        </div>
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <div class="form-group required">
                                <label class="control-label" for="fpwd_lama">Password Lama</label>
                                <input type="password"
                                    class="form-control <?= form_error('fpwd_lama') ? 'is-invalid' : '' ?>"
                                    id="fpwd_lama" name="fpwd_lama" placeholder="Password lama"
                                    value="<?= $this->input->post('fpwd_lama'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fpwd_lama') ?>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group required">
                                <label class="control-label" for="fpwd_baru">Password Baru</label>
                                <input type="password"
                                    class="form-control <?= form_error('fpwd_baru') ? 'is-invalid' : '' ?>"
                                    id="fpwd_baru" name="fpwd_baru" placeholder="Password baru"
                                    value="<?= $this->input->post('fpwd_baru'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fpwd_baru') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fpwd_baru_conf">Ulangi Password Baru</label>
                                <input type="password"
                                    class="form-control <?= form_error('fpwd_baru_conf') ? 'is-invalid' : '' ?>"
                                    id="fpwd_baru_conf" name="fpwd_baru_conf" placeholder="Ulangi password baru"
                                    value="<?= $this->input->post('fpwd_baru_conf'); ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('fpwd_baru_conf') ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-right mt-2">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>