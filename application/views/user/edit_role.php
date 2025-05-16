<section class="content-header align-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Edit Role User</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            <input type="hidden" name="fid_user" value="<?= encrypt_url($user->id_user) ?>">
                            
                            <div class="form-group">
                                <label>Nama User</label>
                                <input type="text" class="form-control" value="<?= $user->nama_user ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label>Role Saat Ini</label>
                                <input type="text" class="form-control" value="<?= $user->group_user ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label>Role Baru *</label>
                                <select name="fid_group_user" class="form-control" required>
                                    <option value="">- Pilih -</option>
                                    <?php foreach ($group_user as $key): ?>
                                        <option value="<?= $key->id_group_user ?>"><?= $key->group_user ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="<?= base_url('users/list') ?>" class="btn btn-default">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>