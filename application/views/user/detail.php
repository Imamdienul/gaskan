<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>DETAIL PENGGUNA</h1>
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
                            <div class="form-group ">
                                <label class="control-label" for="fname_user">Nama Lengkap</label>
                                <input type="text" class="form-control" value="<?= strtoupper($user->nama_user) ?>"
                                    disabled>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="fname_user">Email</label>
                                <input type="text" class="form-control" value="<?= strtoupper($user->email_user) ?>"
                                    disabled>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="fname_user">Handphone</label>
                                <input type="text" class="form-control" value="<?= strtoupper($user->phone_user) ?>"
                                    disabled>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label" for="fname_user">Rekening</label>
                                        <input type="text" class="form-control"
                                            value="<?= strtoupper($user->no_rekening) ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label" for="fname_user">Bank</label>
                                        <input type="text" class="form-control" value="<?= strtoupper($user->bank) ?>"
                                            disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="control-label" for="fname_user">Tanggal Join</label>
                                <input type="text" class="form-control" value="<?= TanggalIndo($user->tgl_join) ?>"
                                    disabled>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="fname_user">Group User</label>
                                <input type="text" class="form-control" value="<?= strtoupper($user->group_user) ?>"
                                    disabled>
                            </div>
                            <a href="<?= base_url('users/list') ?>"
                                class="btn btn-secondary float-left mt-2">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>